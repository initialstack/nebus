<?php declare(strict_types=1);

namespace App\Buses;

use Illuminate\Contracts\Bus\Dispatcher;

final class QueryBus implements QueryBusInterface
{
    /**
     * The underlying dispatcher for handling query execution.
     *
     * @var Dispatcher
     */
    private Dispatcher $queryBus;

    /**
     * Constructs a new QueryBus instance.
     *
     * @param Dispatcher $queryBus
     */
    public function __construct(Dispatcher $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * Executes a query and returns the result.
     *
     * @param object $query
     * @return mixed
     */
    public function ask(object $query): mixed
    {
        return $this->queryBus->dispatch(command: $query);
    }

    /**
     * Registers a mapping of queries to their handlers.
     *
     * @param array<string, string> $map
     */
    public function register(array $map): void
    {
        $this->queryBus->map(map: $map);
    }
}
