<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class CheckFirstCreationSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Only allow access if no superadmin exists
        if ($this->isSuperAdminExists()) {
            abort(404);
        }

        return $next($request);
    }

    protected function isSuperAdminExists(): bool
    {
        return Role::where('name', 'superadmin')->whereHas('users')->exists();
    }
}
