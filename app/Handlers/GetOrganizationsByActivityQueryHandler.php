<?php declare(strict_types=1);

namespace App\Handlers;

use App\Queries\GetOrganizationsByActivityQuery;
use App\Repositories\OrganizationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetOrganizationsByActivityQueryHandler
{
    /**
     * Constructs a new GetOrganizationsByActivityQueryHandler instance.
     *
     * @param OrganizationRepositoryInterface $repository
     */
    public function __construct(
        private OrganizationRepositoryInterface $repository
    ) {}

    /**
     * Handles the GetOrganizationsByActivityQuery and returns paginated organizations.
     *
     * @param GetOrganizationsByActivityQuery $query
     * @return LengthAwarePaginator<int, \App\Models\Organization>
     */
    public function handle(GetOrganizationsByActivityQuery $query): LengthAwarePaginator
    {
        return $this->repository->getByActivity(id: $query->activityId);
    }
}
