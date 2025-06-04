<?php declare(strict_types=1);

namespace App\Http\Controllers\Search\Activity;

use App\Shared\Controller;
use App\Http\Requests\SearchRequest;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Route;
use App\Http\Responses\ResourceResponse;

#[Prefix(prefix: 'v1')]
#[Middleware(middleware: 'auth:sanctum')]
final class SearchActivityAction extends Controller
{
    public function __construct(
        private readonly SearchActivityResponder $responder
    ) {}

    #[Route(methods: ['GET'], uri: '/activities/search/organizations')]
    public function __invoke(SearchRequest $request): ResourceResponse
    {
        return $this->responder->handle(request: $request);
    }
}
