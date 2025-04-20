<?php
namespace App\Http\Middleware;

use App\Services\ActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check()) {
            $routeName = $request->route()->getName();
            $method = $request->method();

            ActivityLogger::log(
                'route_access',
                "Accessed {$method} {$routeName}",
                null,
                [
                    'route' => $routeName,
                    'method' => $method,
                    'url' => $request->fullUrl(),
                ]
            );
        }

        return $response;
    }
}
