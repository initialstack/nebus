<?php declare(strict_types=1);

namespace App\Queries;

final class GetOrganizationsByLocationQuery
{
    /**
     * Constructs a new GetOrganizationsByLocationQuery instance.
     *
     * @param float $minLng
     * @param float $minLat
     * @param float $maxLng
     * @param float $maxLat
     */
    public function __construct(
        public private(set) float $minLng,
        public private(set) float $minLat,
        public private(set) float $maxLng,
        public private(set) float $maxLat
    ) {}

    public function __invoke() {}
}
