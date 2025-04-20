<?php

namespace App\Http\Middleware;

use App\Models\IpRecord;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DeactivatedAccountChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::id();

        $user = User::where('id', $userId)->where('status', 'Deactivated')->first();

        if ($user && Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('voter.login')->with('error', 'You account has been deactivated. Please contact comelec technical support .');
        }

        return $next($request);
    }
}
