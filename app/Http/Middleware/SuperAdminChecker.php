<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if a user with the 'superadmin' role exists
        $superAdminExists = Role::where('name', 'superadmin')->whereHas('users')->exists();

        if (!$superAdminExists) {
            // If no superadmin exists, abort or redirect
            return redirect()->route('admin.register');
        }
        return $next($request);
    }
}
