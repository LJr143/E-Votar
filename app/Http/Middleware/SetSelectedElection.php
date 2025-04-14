<?php

namespace App\Http\Middleware;

use App\Models\Election;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSelectedElection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Update election statuses before proceeding
        $now = now();

        Election::where('date_started', '<=', $now)
            ->where('status', 'upcoming')
            ->update(['status' => 'ongoing']);

        Election::where('date_ended', '<', $now)
            ->where('status', 'ongoing')
            ->update(['status' => 'completed']);

        // Your existing session logic
        if (!session()->has('selectedElection')) {
            $latestElection = Election::latest('created_at')->first();
            session(['selectedElection' => $latestElection->id ?? null]);
        }

        return $next($request);
    }
}
