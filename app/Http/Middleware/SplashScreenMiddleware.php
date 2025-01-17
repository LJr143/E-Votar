<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SplashScreenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $splashRoutes = [
            'admin.login',
            'admin.dashboard',
            'dashboard',
        ];

        if (in_array($request->route()->getName(), $splashRoutes)) {
            session(['showSplash' => true]);
        }

        return $next($request);
    }
}
