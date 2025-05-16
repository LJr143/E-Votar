<?php

namespace App\Http\Controllers;

use App\Events\IpRecordCreated;
use App\Events\UserLoggedIn;
use App\Models\IpRecord;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\RoleRedirectService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

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
        if (auth()->check() && !request()->is('admin/login')) {
            return $this->authenticated(request(), auth()->user());
        }
        return view('evotar.common-admin.login');
    }

    public function loginVoter()
    {
        if (auth()->check()) {
            return $this->authenticated(request(), auth()->user());
        }
        return view('evotar.voter.auth.login');
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

    /**
     * Handle Voter login authentication.
     */
    public function authenticateVoter(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            if (auth()->user()->hasRole('voter')) {
                $request->session()->regenerate();
                $user = User::find(auth()->user()->id);
                Log::info('Dispatching UserLoggedIn for user: ' . $user->id);
                UserLoggedIn::dispatch($user);
                return $this->authenticated($request, auth()->user());
            } else {
                auth()->logout();
                return back()->withErrors([
                    'error' => 'You do not have permission to access this area.',
                ]);
            }
        }

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    public function updateFaceVerified(Request $request)
    {
        $request->validate(['face_verified' => 'required|boolean']);

        session([
            'face_verified' => true,
            'face_verified_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::searchEncrypted($googleUser->getEmail(), ['email'])->first();

            if ($user) {
                $user->google_id = $googleUser->getId();
                $user->save();
                Auth::login($user, true);

                // Create or update IpRecord and broadcast event for Google login
                $ipAddress = request()->ip();
                $ipRecord = IpRecord::updateOrCreate(
                    ['user_id' => $user->id],
                    ['ip_address' => $ipAddress, 'status' => 'allowed', 'last_seen_at' => now()]
                );
                event(new IpRecordCreated($ipRecord));

                return $this->authenticated(request(), $user);
            } else {
                return redirect()->route('voter.login')->withErrors('No account found with this email.');
            }
        } catch (\Exception $e) {
            \Log::error('Google login error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('voter.login')->withErrors('Something went wrong. Please try again.');
        }
    }
}
