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
        // Define the routes where the splash screen should be shown
        $splashRoutes = [
            'admin.login', // Example route
            'dashboard', // Another example route
        ];

        // Check if the current route is in the splashRoutes array
        if (in_array($request->route()->getName(), $splashRoutes)) {
            // Set a session variable to indicate the splash screen should be shown
            session(['showSplash' => true]);
        }

        return $next($request);
    }
}
