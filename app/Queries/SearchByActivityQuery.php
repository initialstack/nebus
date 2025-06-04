<?php declare(strict_types=1);

namespace App\Queries;

final class SearchByActivityQuery
{
    /**
     * Constructs a new SearchByActivityQuery instance.
     *
     * @param string $activity
     */
    public function __construct(
        public private(set) string $activity
    ) {}

    public function __invoke() {}
}
