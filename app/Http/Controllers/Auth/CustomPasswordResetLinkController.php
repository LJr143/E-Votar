<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use App\Models\User;

class CustomPasswordResetLinkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Use your trait method to find the encrypted user
        $user = User::whereEncrypted('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => __('We can\'t find a user with that email address.')]);
        }

        // Send reset link using the user instance
        $status = Password::broker()->sendResetLink(
            ['email' => $user->email]
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
