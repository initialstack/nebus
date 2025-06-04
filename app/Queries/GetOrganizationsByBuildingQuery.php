<?php declare(strict_types=1);

namespace App\Queries;

final class GetOrganizationsByBuildingQuery
{
    /**
     * Constructs a new GetOrganizationsByBuildingQuery instance.
     *
     * @param string $buildingId
     */
    public function __construct(
        public private(set) string $buildingId
    ) {}

    public function __invoke() {}
}
