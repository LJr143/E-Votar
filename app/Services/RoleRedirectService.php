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

        return redirect()->route('admin.login');
    }
}
