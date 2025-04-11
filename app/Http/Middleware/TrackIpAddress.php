<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\IpRecord;
use Illuminate\Support\Facades\Auth;

class TrackIpAddress
{
    public function handle(Request $request, Closure $next)
    {
        $ipAddress = $request->ip();
        $userId = Auth::id(); // Will be null if not authenticated

        // Find or create the IP record
        $ipRecord = IpRecord::firstOrCreate(
            ['ip_address' => $ipAddress, 'user_id' => $userId],
            ['status' => 'allowed', 'last_seen_at' => now()]
        );

        // Check if the IP is blocked
        if ($ipRecord->status === 'blocked') {
            if (Auth::check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
            return redirect()->route('voter.login')->with('error', 'Your IP is blocked. Please contact support.');
        }

        // Update the record only if it’s not blocked
        $ipRecord->update([
            'status' => 'allowed', // Only if not blocked
            'last_seen_at' => now(),
            'user_id' => $userId ?: $ipRecord->user_id, // Preserve user_id if already set
        ]);

        // Proceed with the request
        return $next($request);
    }
}
