<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearAdminVotingSession
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if we're entering an admin route
        if ($request->is('admin/*')) {
            // Clear the voting session if it exists
            if (session()->has('Admin-Voting-Access')) {
                session()->forget([
                    'Admin-Voting-Access',
                    'Admin-Voting-ID'
                ]);

                // Optional: Add a flash message
                session()->flash('info', 'Exited voting mode automatically');
            }
        }

        return $next($request);
    }
}
