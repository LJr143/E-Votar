<?php

namespace App\Services;

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
        if ($user->hasRole('technical_officer')) {
            return redirect()->route('technical-officer.dashboard');
        }

        return redirect()->route('admin.login');
    }
}
