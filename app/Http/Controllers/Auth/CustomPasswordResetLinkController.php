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

        // Use searchEncrypted which decrypts then compares
        $users = User::searchEncrypted($request->email, ['email']);


        if ($users->isEmpty()) {
            return back()->withErrors(['email' => __('We can\'t find a user with that email address. Stress na ako')]);
        }

        // Get the first matching user
        $user = $users->first();

        // Send reset link using the user instance
        $status = Password::broker()->sendResetLink(
            ['email' => $user->email]
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
