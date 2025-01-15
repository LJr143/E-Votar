<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleRedirectService;

class LoginController extends Controller
{
    protected RoleRedirectService $roleRedirectService;

    public function __construct(RoleRedirectService $roleRedirectService)
    {
        $this->roleRedirectService = $roleRedirectService;
    }

    /**
     * Handle authenticated user and redirect based on their role.
     */
    protected function authenticated(Request $request, $user)
    {
        return $this->roleRedirectService->redirectBasedOnRole($user);
    }

    /**
     * Show the login page or redirect if the user is already authenticated.
     */
    public function login()
    {
        if (auth()->check()) {
            return $this->authenticated(request(), auth()->user());
        }

        return view('evotar.common-admin.login');
    }

    /**
     * Handle login authentication.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return $this->authenticated($request, auth()->user());
        }

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }
}
