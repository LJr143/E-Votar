<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showAdminLoginForm()
    {
        return view('evotar.common-admin.login');
    }

    public function showVoterLoginForm()
    {
        return view('');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->hasRole('superadmin')) {
                return redirect()->route('super-admin.dashboard');
            }
            Auth::logout();
        }

        return back()->withErrors(['username' => 'Invalid credentials or not an admin.']);
    }

    public function voterLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->hasRole('voter')) {
                return redirect()->route('voter.dashboard');
            }
            Auth::logout();
        }

        return back()->withErrors(['email' => 'Invalid credentials or not a voter.']);
    }
}
