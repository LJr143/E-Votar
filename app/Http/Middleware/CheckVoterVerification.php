<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVoterVerification
{
    public function handle(Request $request, Closure $next): Response
    {
        $voter = $request->user();


        if (!$voter->isVerifiedForCurrentYear()) {
            return redirect()->route('voter.election.redirect')->withErrors('Your Account is Not Currently Verified for this year');
        }

        return $next($request);
    }

}
