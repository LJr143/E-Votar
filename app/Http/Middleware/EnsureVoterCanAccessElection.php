<?php

namespace App\Http\Middleware;

use App\Models\Election;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureVoterCanAccessElection
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/')->with('error', 'You must be logged in.');
        }

        $electionSlug = $request->route('slug');
        $election = Election::where('slug', $electionSlug)->first();

        if (!$election) {
            return abort(404, 'Election not found.');
        }

        // Check if the user is excluded
        $excluded = \DB::table('election_excluded_voters')
            ->where('election_id', $election->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($excluded) {
            return abort(403, 'You are not allowed to access this election.');
        }

        return $next($request);
    }
}
