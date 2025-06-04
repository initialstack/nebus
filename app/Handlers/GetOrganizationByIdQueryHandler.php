<?php declare(strict_types=1);

namespace App\Handlers;

use App\Queries\GetOrganizationByIdQuery;
use App\Repositories\OrganizationRepositoryInterface;
use App\Models\Organization;

final class GetOrganizationByIdQueryHandler
{
    /**
     * Constructs a new GetOrganizationByIdQueryHandler instance.
     *
     * @param OrganizationRepositoryInterface $repository
     */
    public function __construct(
        private OrganizationRepositoryInterface $repository
    ) {}

    /**
     * Handles the GetOrganizationByIdQuery and returns the organization or null if not found.
     *
     * @param GetOrganizationByIdQuery $query
     * @return Organization|null
     */
    public function handle(GetOrganizationByIdQuery $query): ?Organization
    {
        return $this->repository->findById(id: $query->organizationId);
    }
}
