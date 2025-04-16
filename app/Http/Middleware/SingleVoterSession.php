<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class SingleVoterSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

            // Check if the user is authenticated
        if (!$user) {
            // Redirect to login if the user is not authenticated
            return redirect('/');
        }

        $routeRedirect = match (true) {
            $user->hasRole('voter') => 'voter.login',
            default => 'admin.login',
        };



        if ($user) {
            // Check if user has a different active session
            $sessionId = session()->getId();
            $lifetimeInMinutes = config('session.lifetime');
            $threshold = Carbon::now()->subMinutes($lifetimeInMinutes)->timestamp;

            $existingSession = DB::table('sessions')
                ->where('user_id', $user->id)
                ->where('id', '!=', $sessionId)
                ->where('last_activity', '>=', $threshold)
                ->exists();

            if ($existingSession) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                return redirect()->route($routeRedirect)->withErrors([
                    'error' => 'You are already logged in on another device.',
                ]);
            }


        }

        return $next($request);
    }
}
