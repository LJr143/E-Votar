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
        $userId = Auth::id();

        // Find or create the IP record
        $ipRecord = IpRecord::firstOrCreate(
            ['ip_address' => $ipAddress, 'user_id' => $userId],
            ['status' => 'allowed', 'last_seen_at' => now()]
        );

        // Update the status and last seen time
        $ipRecord->update([
            'status' => 'allowed',
            'last_seen_at' => now(),
        ]);

//        // Broadcast the event
//        broadcast(new IpAddressTracked($userId, $ipAddress, 'online'));

        return $next($request);
    }
}
