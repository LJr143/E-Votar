<?php

namespace App\Http\Middleware;

use App\Models\Vote;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ElectionVoteChecker
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $electionSlug = $request->route('slug');

        if (!$electionSlug) {
            return redirect()->route('voter.election.redirect')->with('error', 'Election not specified.');
        }

        // Check if the user has already voted in this election
        $hasVoted = Vote::where('user_id', $user->id)
            ->whereHas('election', function ($query) use ($electionSlug) {
                $query->where('slug', $electionSlug);
            })
            ->exists();

        if ($hasVoted) {
            return redirect()->route('voter.election.redirect')->with('error', 'You have already voted in this election.');
        }

        return $next($request);
    }
}
