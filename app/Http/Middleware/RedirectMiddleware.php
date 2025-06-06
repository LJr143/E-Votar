<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->hasRole('superadmin')) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::check() && Auth::user()->hasAnyRole('student-council-watcher', 'local-council-watcher')) {
            return redirect()->route('watcher.dashboard');
        }
        if (Auth::check() && Auth::user()->hasRole('technical_officer')) {
            return redirect()->route('technical-officer.dashboard');
        }


        return $next($request);
    }
}
