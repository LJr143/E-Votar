<?php

namespace App\Http\Middleware;

use App\Models\Election;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckElectionStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the election ID from route parameters or request
        $electionId = session('selected_election');
        if ($electionId) {
            $election = Election::find($electionId);

            if ($election && $election->status === 'paused') {
                return response()->json([
                    'message' => 'Voting is currently paused',
                    'status' => 'paused'
                ], 403);
            }

            if ($election && $election->date_started > now()) {
                return response()->json([
                    'message' => 'Election has not yet started',
                    'status' => 'pending'
                ], 403);
            }
        }

        return $next($request);
    }
}
