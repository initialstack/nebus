<?php declare(strict_types=1);

namespace App\Http\Controllers\Activity;

use App\Http\Responses\ResourceResponse;
use App\Buses\QueryBusInterface;
use App\Queries\GetOrganizationsByActivityQuery;
use App\Http\Collections\PaginationCollection;
use Illuminate\Http\Response;

final class ActivityResponder
{
    /**
     * Constructs a new ActivityResponder instance.
     *
     * @param QueryBusInterface $queryBus
     */
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    /**
     * Handles the request to get organizations by activity ID.
     *
     * Dispatches a GetOrganizationsByActivityQuery and returns a paginated response.
     * If no organizations are found, returns a 404 response with a message.
     *
     * @param string $id
     * @return ResourceResponse
     */
    public function handle(string $id): ResourceResponse
    {
        $organizations = $this->queryBus->ask(
            query: new GetOrganizationsByActivityQuery(
                activityId: $id
            )
        );

        if (!blank(value: $organizations)) {
            return new ResourceResponse(
                data: new PaginationCollection(
                    resource: $organizations
                ),
                status: Response::HTTP_OK
            );
        }

        return new ResourceResponse(
            data: [
                'message' => __('No organizations found.')
            ],
            status: Response::HTTP_NOT_FOUND
        );
    }
}
