<?php

namespace App\Http\Middleware;

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

        if ($user) {
            $sessionId = session()->getId();

            // Check if user has a different active session
            $existingSession = DB::table('sessions')
                ->where('user_id', $user->id)
                ->where('id', '!=', $sessionId)
                ->exists();

            if ($existingSession) {
                Auth::logout();
                return redirect()->route('voter.login')->withErrors([
                    'error' => 'You are already logged in on another device.',
                ]);
            }

        }

        return $next($request);
    }
}
