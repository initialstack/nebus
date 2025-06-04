<?php declare(strict_types=1);

namespace App\Http\Controllers\Search\Organization;

use App\Buses\QueryBusInterface;
use App\Queries\SearchByNameQuery;
use App\Http\Collections\PaginationCollection;
use App\Http\Requests\SearchRequest;
use App\Http\Responses\ResourceResponse;
use Illuminate\Http\Response;

final class SearchOrganizationResponder
{
    /**
     * Constructs a new SearchOrganizationResponder instance.
     *
     * @param QueryBusInterface $queryBus
     */
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    /**
     * Handles the search request for organizations by name.
     *
     * Dispatches a SearchByNameQuery with the search string extracted from the request.
     * Returns a paginated list of organizations matching the name search.
     * If no organizations are found, returns a 404 response with a message.
     *
     * @param SearchRequest $request
     * @return ResourceResponse
     */
    public function handle(SearchRequest $request): ResourceResponse
    {
        $organizations = $this->queryBus->ask(
            query: new SearchByNameQuery(
                name: $request->string('query')->value()
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

        return new ResourceResponse(data: [
            'message' => __('Organization Not Found.')
        ], status: Response::HTTP_NOT_FOUND);
    }
}
