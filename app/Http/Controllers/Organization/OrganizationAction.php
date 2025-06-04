<?php declare(strict_types=1);

namespace App\Http\Controllers\Organization;

use App\Shared\Controller;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Attributes\WhereUuid;
use App\Http\Responses\ResourceResponse;

#[Prefix(prefix: 'v1')]
#[Middleware(middleware: 'auth:sanctum')]
#[WhereUuid(param: 'id')]
final class OrganizationAction extends Controller
{
    public function __construct(
        private readonly OrganizationResponder $responder
    ) {}
    
    #[Route(methods: ['GET'], uri: '/organizations/{id}')]
    public function __invoke(string $id): ResourceResponse
    {
        return $this->responder->handle(id: $id);
    }
}
