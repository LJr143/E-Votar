<?php

namespace App\Http\Middleware;

use App\Models\IpRecord;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBlockedIp
{
    public function handle(Request $request, Closure $next)
    {
        $ipAddress = $request->ip();

        $ipRecord = IpRecord::where('ip_address', $ipAddress)
            ->where('status', 'blocked')
            ->first();

        if ($ipRecord && Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('voter.login')->with('error', 'Your IP has been blocked. Please contact support.');
        }

        return $next($request);
    }
}
