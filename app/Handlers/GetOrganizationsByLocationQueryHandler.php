<?php declare(strict_types=1);

namespace App\Handlers;

use App\Queries\GetOrganizationsByLocationQuery;
use App\Repositories\OrganizationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetOrganizationsByLocationQueryHandler
{
    /**
     * Constructs a new GetOrganizationsByLocationQueryHandler instance.
     *
     * @param OrganizationRepositoryInterface $repository
     */
    public function __construct(
        private OrganizationRepositoryInterface $repository
    ) {}

    /**
     * Handles the GetOrganizationsByLocationQuery and returns paginated organizations within the bounding box.
     *
     * @param GetOrganizationsByLocationQuery $query
     * @return LengthAwarePaginator<int, \App\Models\Organization>
     */
    public function handle(GetOrganizationsByLocationQuery $query): LengthAwarePaginator
    {
        return $this->repository->getByLocation(
            data: [
                'min_lng' => $query->minLng,
                'min_lat' => $query->minLat,
                'max_lng' => $query->maxLng,
                'max_lat' => $query->maxLat,
            ]
        );
    }
}
