<?php declare(strict_types=1);

namespace App\Queries;

final class GetOrganizationByIdQuery
{
    /**
     * Constructs a new GetOrganizationrByIdQuery instance.
     *
     * @param string $organizationId
     */
    public function __construct(
        public private(set) string $organizationId
    ) {}

    public function __invoke() {}
}
