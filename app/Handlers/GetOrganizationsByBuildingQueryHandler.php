<?php declare(strict_types=1);

namespace App\Handlers;

use App\Queries\GetOrganizationsByBuildingQuery;
use App\Repositories\OrganizationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetOrganizationsByBuildingQueryHandler
{
    /**
     * Constructs a new GetOrganizationsByBuildingQueryHandler instance.
     *
     * @param OrganizationRepositoryInterface $repository
     */
    public function __construct(
        private OrganizationRepositoryInterface $repository
    ) {}

    /**
     * Handles the GetOrganizationsByActivityQuery and returns paginated organizations.
     *
     * @param GetOrganizationsByBuildingQuery $query
     * @return LengthAwarePaginator<int, \App\Models\Organization>
     */
    public function handle(GetOrganizationsByBuildingQuery $query): LengthAwarePaginator
    {
        return $this->repository->getByBuilding(id: $query->buildingId);
    }
}
