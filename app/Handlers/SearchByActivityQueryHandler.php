<?php declare(strict_types=1);

namespace App\Handlers;

use App\Queries\SearchByActivityQuery;
use App\Repositories\OrganizationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class SearchByActivityQueryHandler
{
    /**
     * Constructs a new SearchByActivityQueryHandler instance.
     *
     * @param OrganizationRepositoryInterface $repository
     */
    public function __construct(
        private OrganizationRepositoryInterface $repository
    ) {}

    /**
     * Handles the SearchByActivityQuery and returns paginated search results.
     *
     * @param SearchByActivityQuery $query
     * @return LengthAwarePaginator<int, \App\Models\Organization>
     */
    public function handle(SearchByActivityQuery $query): LengthAwarePaginator
    {
        return $this->repository->searchByActivity(query: $query->activity);
    }
}
