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
        // Check if selectedElection is not set in the session
        if (!session()->has('selectedElection')) {
            // Fetch the latest election
            $latestElection = Election::latest('created_at')->first();

            // Set the selectedElection in the session
            session(['selectedElection' => $latestElection->id ?? null]);
        }

        return $next($request);
    }
}
