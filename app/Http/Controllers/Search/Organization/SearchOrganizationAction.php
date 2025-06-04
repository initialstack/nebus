<?php declare(strict_types=1);

namespace App\Http\Controllers\Search\Organization;

use App\Shared\Controller;
use App\Http\Requests\SearchRequest;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Route;
use App\Http\Responses\ResourceResponse;

#[Prefix(prefix: 'v1')]
#[Middleware(middleware: 'auth:sanctum')]
final class SearchOrganizationAction extends Controller
{
    public function __construct(
        private readonly SearchOrganizationResponder $responder
    ) {}

    #[Route(methods: ['GET'], uri: '/organizations/search')]
    public function __invoke(SearchRequest $request): ResourceResponse
    {
        return $this->responder->handle(request: $request);
    }
}
