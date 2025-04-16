<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class SuperadminChecker
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isSuperAdminExists()) {
            return redirect()->route('admin.register.get.superadmin');
        }

        return $next($request);
    }

    /**
     * Check if a superadmin exists.
     */
    protected function isSuperAdminExists(): bool
    {
        return Role::where('name', 'superadmin')->whereHas('users')->exists();
    }
}
