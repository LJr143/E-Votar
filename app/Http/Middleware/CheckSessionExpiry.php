<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() && $request->session()->has('last_activity')) {
            $sessionLifetime = config('session.lifetime') * 60;
            if (time() - $request->session()->get('last_activity') > $sessionLifetime) {
                $request->session()->flush();
                return redirect()->route('voter.login')->with('session_expired', true);
            }
        }

        $request->session()->put('last_activity', time());
        return $next($request);
    }
}
