<?php declare(strict_types=1);

namespace App\Queries;

final class SearchByNameQuery
{
    /**
     * Constructs a new SearchByNameQuery instance.
     *
     * @param string $name
     */
    public function __construct(
        public private(set) string $name
    ) {}

    public function __invoke() {}
}
