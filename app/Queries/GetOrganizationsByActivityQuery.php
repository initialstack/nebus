<?php declare(strict_types=1);

namespace App\Queries;

final class GetOrganizationsByActivityQuery
{
    /**
     * Constructs a new GetOrganizationsByActivityQuery instance.
     *
     * @param string $activityId
     */
    public function __construct(
        public private(set) string $activityId
    ) {}

    public function __invoke() {}
}
