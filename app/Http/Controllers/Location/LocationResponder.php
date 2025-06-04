<?php declare(strict_types=1);

namespace App\Http\Controllers\Location;

use App\Http\Responses\ResourceResponse;
use App\Queries\GetOrganizationsByLocationQuery;
use App\Buses\QueryBusInterface;
use App\Http\Requests\LocationRequest;
use App\Http\Collections\PaginationCollection;
use Illuminate\Http\Response;

final class LocationResponder
{
    /**
     * Constructs a new LocationResponder instance.
     *
     * @param QueryBusInterface $queryBus
     */
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    /**
     * Handles the request to get organizations by location coordinates.
     *
     * Dispatches a GetOrganizationsByLocationQuery with bounding coordinates and returns a paginated response.
     * If no organizations are found, returns a 404 response with a message.
     *
     * @param LocationRequest $request
     * @return ResourceResponse
     */
    public function handle(LocationRequest $request): ResourceResponse
    {
        $minLng = $this->toFloat(value: $request->input('min_lng'));
        $minLat = $this->toFloat(value: $request->input('min_lat'));
        $maxLng = $this->toFloat(value: $request->input('max_lng'));
        $maxLat = $this->toFloat(value: $request->input('max_lat'));

        $organizations = $this->queryBus->ask(
            query: new GetOrganizationsByLocationQuery(
                minLng: $minLng,
                minLat: $minLat,
                maxLng: $maxLng,
                maxLat: $maxLat
            )
        );

        if (!blank(value: $organizations)) {
            return new ResourceResponse(
                data: new PaginationCollection(resource: $organizations),
                status: Response::HTTP_OK
            );
        }

        return new ResourceResponse(
            data: ['message' => __('No organizations found.')],
            status: Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Safely convert mixed value to float, or throw exception if invalid.
     *
     * @param mixed $value
     * @return float
     * @throws \InvalidArgumentException
     */
    private function toFloat(mixed $value): float
    {
        if (is_numeric(value: $value)) {
            return (float) $value;
        }

        throw new \InvalidArgumentException(
            message: 'Expected numeric value, got ' . gettype($value)
        );
    }
}
