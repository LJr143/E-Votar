<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use App\Models\IpRecord;
use Illuminate\Support\Facades\Auth;

class TrackIpAddress
{
    public function handle(Request $request, Closure $next)
    {
        $ipAddress = $request->ip();
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        if ($userId !== null) {

            $ipRecord = IpRecord::firstOrCreate(
                ['ip_address' => $ipAddress, 'user_id' => $userId],
                ['status' => 'allowed', 'last_seen_at' => now()]
            );

            if ($user->status === 'blocked') {
                if (Auth::check()) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                }
                return redirect()->route('voter.login')->with('error', 'You are blocked on this IP. Please contact comelec technical support.');
            }

            $ipRecord->update([
                'status' => 'allowed',
                'last_seen_at' => now(),
                'user_id' => $userId ?: $ipRecord->user_id,
            ]);
        }

        return $next($request);
    }
}
