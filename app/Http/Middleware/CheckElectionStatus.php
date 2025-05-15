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
        $electionId = session('selected_election');

        if (!$electionId) {
            return response()->json([
                'message' => 'No election selected',
                'status' => 'missing'
            ], 400); // 400 Bad Request is more appropriate
        }

        $election = Election::find($electionId);

        if (!$election) {
            return response()->json([
                'message' => 'Election not found',
                'status' => 'not_found'
            ], 404);
        }

        // Check election status in order of priority
        if ($election->status === 'paused') {
            return response()->json([
                'message' => 'Voting is currently paused',
                'status' => 'paused',
                'resumes_at' => $election->paused_until // Add if you track pause duration
            ], 403);
        }

        if ($election->date_started > now()) {
            return response()->json([
                'message' => 'Election has not yet started',
                'status' => 'pending',
                'starts_in' => now()->diffForHumans($election->date_started)
            ], 403);
        }

        if ($election->date_ended <= now()) {
            return response()->json([
                'message' => 'Election has ended',
                'status' => 'ended',
                'ended_at' => $election->date_ended->format('Y-m-d H:i:s')
            ], 403);
        }

        return $next($request);
    }
}
