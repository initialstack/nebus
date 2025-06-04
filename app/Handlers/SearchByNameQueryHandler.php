<?php declare(strict_types=1);

namespace App\Handlers;

use App\Queries\SearchByNameQuery;
use App\Repositories\OrganizationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class SearchByNameQueryHandler
{
    /**
     * Constructs a new SearchByNameQueryHandler instance.
     *
     * @param OrganizationRepositoryInterface $repository
     */
    public function __construct(
        private OrganizationRepositoryInterface $repository
    ) {}

    /**
     * Handles the SearchByNameQuery and returns paginated search results.
     *
     * @param SearchByNameQuery $query
     * @return LengthAwarePaginator<int, \App\Models\Organization>
     */
    public function handle(SearchByNameQuery $query): LengthAwarePaginator
    {
        return $this->repository->searchByName(query: $query->name);
    }
}
