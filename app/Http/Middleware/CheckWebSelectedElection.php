<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWebSelectedElection
{
    public function handle(Request $request, Closure $next): Response
    {
        if (  !session('selectedElectionWeb')){
            return redirect()->route('comelec-website.home');
        }
        return $next($request);
    }
}
