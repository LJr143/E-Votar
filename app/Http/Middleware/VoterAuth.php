<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VoterAuth
{
    public function handle(Request $request, Closure $next, $permission = null): Response
    {
        // First check authentication
        if (!Auth::check()) {
            return $this->redirectToLogin($request, 'You must be logged in to access this page.');
        }

        $user = Auth::user();

        // Allow access if either voter OR admin
        if (!$this->isVoter($user) && !$this->isAdmin($user, $request)) {
            return $this->redirectWithOrigin($request, 'Your account does not have voting access.');
        }

        // Check additional permissions if specified
        if ($permission && !$user->can($permission)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }

    protected function isVoter($user): bool
    {
        return $user->hasRole('voter');
    }

    protected function isAdmin($user, Request $request): bool
    {
        $isAdmin = $user->hasAnyRole(['superadmin', 'admin', 'technical_officer', 'student-council-watcher', 'local-council-watcher']);

        if ($isAdmin && !session('Admin-Voting-Access')) {
            session([
                'Admin-Voting-Access' => true,
                'Admin-Voting-ID' => $user->id,
                'Admin-Voting-Name' => $user->first_name,
                'Admin-Voting-Time' => now(),
                'Admin-Voting-Origin' => url()->previous()
            ]);
        }

        return $isAdmin;
    }

    protected function redirectToLogin(Request $request, string $message): Response
    {
        // Store intended URL before redirect
        session()->put('url.intended', $request->fullUrl());

        return redirect()->route('voter.login')
            ->withErrors(['error' => $message]);
    }

    protected function redirectWithOrigin(Request $request, string $message): Response
    {
        // For admin trying to access voter area without voting mode
        if ($this->isAdmin(Auth::user(), $request)) {
            return redirect(session('Admin-Voting-Origin', route('admin.dashboard')))
                ->withErrors(['error' => $message]);
        }

        // For regular voters
        return redirect()->route('voter.dashboard')
            ->withErrors(['error' => $message]);
    }
}
