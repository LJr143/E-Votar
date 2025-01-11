<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('admin.login')->withErrors([
                'error' => 'You must be logged in to access this page.',
            ]);
        }

        // Get the authenticated user
        $user = Auth::user();
        // Check if the user has any of the required roles
        if (!$user->hasAnyRole('superadmin')) {
            // If the user doesn't have any of the required roles, return an error
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('super-admin.login');
    }
}
