<?php declare(strict_types=1);

namespace App\Http\Controllers\Location;

use App\Shared\Controller;
use App\Http\Requests\LocationRequest;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Route;
use App\Http\Responses\ResourceResponse;

#[Prefix(prefix: 'v1')]
#[Middleware(middleware: 'auth:sanctum')]
final class LocationAction extends Controller
{
    public function __construct(
        private readonly LocationResponder $responder
    ) {}

    #[Route(methods: ['GET'], uri: '/organizations/location')]
    public function __invoke(
        LocationRequest $request): ResourceResponse
    {
        return $this->responder->handle(request: $request);
    }
}
