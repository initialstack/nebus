<?php declare(strict_types=1);

namespace App\Http\Middlewares;

use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Support\Facades\{Context, Log};
use Illuminate\Support\Str;

final class ApiRequestLogger
{
    /**
     * Handles the request by logging relevant data and passing it to the next middleware.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, \Closure $next)
    {
        Context::add(key: 'request_id', value: Str::uuid()->toString());
        Context::add(key: 'timestamp', value: now()->toIso8601String());

        Context::add(key: 'path', value: $request->path());
        Context::add(key: 'method', value: $request->method());

        $startTime = microtime(as_float: true);

        $responseTime = round(
            num: (microtime(as_float: true) - $startTime) * 1000,
            precision: 2
        );
        
        $response = $next($request);

        Context::add(key: 'response_time', value: $responseTime);
        Context::add(key: 'status_code', value: $response->getStatusCode());

        Log::info(message: 'API Request Processed');

        return $response;
    }
}
