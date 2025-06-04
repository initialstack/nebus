<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Buses\QueryBusInterface;
use App\Handlers\GetOrganizationByIdQueryHandler;
use App\Queries\GetOrganizationByIdQuery;
use App\Handlers\GetOrganizationsByBuildingQueryHandler;
use App\Queries\GetOrganizationsByBuildingQuery;
use App\Handlers\GetOrganizationsByLocationQueryHandler;
use App\Queries\GetOrganizationsByLocationQuery;
use App\Handlers\GetOrganizationsByActivityQueryHandler;
use App\Queries\GetOrganizationsByActivityQuery;
use App\Handlers\SearchByActivityQueryHandler;
use App\Queries\SearchByActivityQuery;
use App\Handlers\SearchByNameQueryHandler;
use App\Queries\SearchByNameQuery;

final class QueryServiceProvider extends ServiceProvider
{
    /**
     * Mapping of queries to their handlers.
     * 
     * @var array
     */
    private array $queries = [
        GetOrganizationByIdQuery::class => GetOrganizationByIdQueryHandler::class,
        GetOrganizationsByBuildingQuery::class => GetOrganizationsByBuildingQueryHandler::class,
        GetOrganizationsByLocationQuery::class => GetOrganizationsByLocationQueryHandler::class,
        GetOrganizationsByActivityQuery::class => GetOrganizationsByActivityQueryHandler::class,
        SearchByActivityQuery::class => SearchByActivityQueryHandler::class,
        SearchByNameQuery::class => SearchByNameQueryHandler::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(QueryBusInterface $queryBus): void
    {
        $queryBus->register(map: $this->queries);
    }
}
