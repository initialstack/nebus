<?php declare(strict_types=1);

namespace App\Http\Controllers\Organization;

use App\Buses\QueryBusInterface;
use App\Queries\GetOrganizationByIdQuery;
use App\Http\Resources\OrganizationResource;
use App\Http\Responses\ResourceResponse;
use Illuminate\Http\Response;

final class OrganizationResponder
{
    /**
     * Constructs a new OrganizationResponder instance.
     *
     * @param QueryBusInterface $queryBus
     */
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    /**
     * Handles the request to get an organization by its ID.
     *
     * Dispatches a GetOrganizationByIdQuery and returns the organization resource.
     * If the organization is not found, returns a 404 response with a message.
     *
     * @param string $id
     * @return ResourceResponse
     */
    public function handle(string $id): ResourceResponse
    {
        $organization = $this->queryBus->ask(
            query: new GetOrganizationByIdQuery(
                organizationId: $id
            )
        );

        if (!blank(value: $organization)) {
            return new ResourceResponse(
                data: new OrganizationResource(resource: $organization),
                status: Response::HTTP_OK
            );
        }

        return new ResourceResponse(
            data: ['message' => __('Organization Not Found.')],
            status: Response::HTTP_NOT_FOUND
        );
    }
}
