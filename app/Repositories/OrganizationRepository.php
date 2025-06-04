<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Clickbar\Magellan\Database\PostgisFunctions\ST;
use Clickbar\Magellan\Database\Expressions\AsGeometry;
use Clickbar\Magellan\Data\Geometries\Polygon;
use App\Models\{Organization, Activity};

final class OrganizationRepository implements OrganizationRepositoryInterface
{
    /**
     * Constructs a new OrganizationRepository instance.
     * 
     * @param Organization $organization
     * @param Activity $activity
     */
    public function __construct(
        private readonly Organization $organization,
        private readonly Activity $activity
    ) {}

    /**
     * Find an organization by its unique identifier.
     *
     * @param string $id
     * @return Organization|null
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(string $id): ?Organization
    {
        return $this->organization->query()->with(
            relations: ['phones', 'building']
        )->findOrFail(
            id: $id
        );
    }

    /**
     * Retrieve organizations associated with a specific building.
     *
     * @param string $id
     * @return LengthAwarePaginator
     */
    public function getByBuilding(string $id): LengthAwarePaginator
    {
        return $this->organization->query()->where(
            column: 'building_id',
            operator: '=',
            value: $id
        )->with(
            relations: ['phones', 'building']
        )->paginate(
            perPage: 10
        );
    }

    /**
     * Retrieve organizations associated with a specific activity.
     *
     * @param string $id
     * @return LengthAwarePaginator
     */
    public function getByActivity(string $id): LengthAwarePaginator
    {
        return $this->organization->query()->whereHas(
            relation: 'activities',
            callback: fn (Builder $query): Builder => $query->where(
                column: 'activities.id',
                operator: '=',
                value: $id
            )
        )->with(
            relations: ['phones', 'activities', 'building']
        )->paginate(
            perPage: 10
        );
    }

    /**
     * Retrieve organizations located within a specified geographic bounding box.
     * Uses PostGIS ST_Contains and ST_MakeEnvelope to filter organizations by building location.
     *
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getByLocation(array $data): LengthAwarePaginator
    {
        return $this->organization->query()->whereHas(
            relation: 'building',
            callback: function (Builder $query) use ($data): void {
                $query->whereRaw(
                    sql: 'ST_Contains(ST_MakeEnvelope(?, ?, ?, ?, 4326), location)',
                    bindings: [
                        data_get(target: $data, key: 'min_lng'),
                        data_get(target: $data, key: 'min_lat'),
                        data_get(target: $data, key: 'max_lng'),
                        data_get(target: $data, key: 'max_lat')
                    ]
                );
            })->with(
                relations: ['phones', 'activities', 'building']
            )->paginate(
                perPage: 10
            );
    }

    /**
     * Search organizations by name using case-insensitive partial matching.
     *
     * @param string $query
     * @return LengthAwarePaginator
     */
    public function searchByName(string $query): LengthAwarePaginator
    {
        return $this->organization->query()->where(
            column: 'name',
            operator: 'ILIKE',
            value: "%{$query}%"
        )->with(
            relations: ['phones', 'activities', 'building']
        )->paginate(
            perPage: 10
        );
    }

    /**
     * Search organizations by activity name, including child activities up to a max level.
     * Performs a breadth-first search on activity hierarchy to include child activities up to level 3.
     *
     * @param string $query
     * @return LengthAwarePaginator
     */
    public function searchByActivity(string $query): LengthAwarePaginator
    {
        $maxLevel = 3;

        // Find activities matching the query
        $activities = $this->activity->query()->where(
            column: 'name',
            operator: 'ILIKE',
            value: "%{$query}%"
        )->get();

        // Return empty paginator if no activities found
        if ($activities->isEmpty()) {
            return $this->organization->query()->whereRaw(
                sql: '0=1'
            )->paginate(
                perPage: 10
            );
        }

        $activityIds = [];
        $queue = [];

        // Initialize queue with found activities at level 1
        foreach ($activities as $activity) {
            $activityIds[] = $activity->id;
            $queue[] = [$activity->id, 1];
        }

        // BFS to collect child activity IDs up to max level
        while (count($queue) > 0) {
            [$currentId, $level] = array_shift(array: $queue);

            if ($level >= $maxLevel) {
                continue;
            }

            $childIds = $this->activity->query()->where(
                column: 'parent_id',
                operator: '=',
                value: $currentId
            )->pluck(
                column: 'id'
            )->toArray();

            $activityIds = [...$activityIds, ...$childIds];

            foreach ($childIds as $childId) {
                $queue[] = [$childId, $level + 1];
            }
        }

        // Query organizations linked to any of the collected activity IDs
        return $this->organization->query()->whereHas(
            relation: 'activities',
            callback: function (Builder $query) use ($activityIds): void {
                $query->whereIn(
                    column: 'activities.id',
                    values: $activityIds
                );
            }
        )->with(
            relations: ['phones', 'activities', 'building']
        )->paginate(
            perPage: 10
        );
    }
}
