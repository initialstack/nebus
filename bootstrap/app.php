<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middlewares\ApiRequestLogger;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [HandleCors::class]);
        $middleware->appendToGroup(
            group: 'api',
            middleware: [
                SubstituteBindings::class,
                ApiRequestLogger::class,
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->level(
            type: \PDOException::class,
            level: \Psr\Log\LogLevel::CRITICAL
        );
    })->create();
