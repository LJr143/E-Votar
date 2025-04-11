<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class RoleRedirectService
{
    public function redirectBasedOnRole($user): \Illuminate\Http\RedirectResponse
    {
        if ($user->hasRole('superadmin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasAnyRole('student-council-watcher', 'local-council-watcher')) {
            return redirect()->route('watcher.dashboard');
        }
        if ($user->hasRole('technical_officer')) {
            return redirect()->route('technical-officer.dashboard');
        }
        if ($user->hasRole('voter')) {
            return redirect()->route('voter.election.redirect');
        }

        // Log out and redirect only if no valid role
        Auth::logout();
        return redirect()->route('admin.login')->withErrors(['error' => 'No valid role assigned.']);
    }
}
