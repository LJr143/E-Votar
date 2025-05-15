<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Fortify;

class CustomPasswordResetLinkController extends Controller
{
    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     * @return Responsable
     */
    public function store(Request $request)
    {
        $request->validate([Fortify::email() => 'required|email']);

        $email = $request->{Fortify::email()};

        if (config('fortify.lowercase_usernames')) {
            $email = Str::lower($email);
        }

        // Search for user with encrypted email
        $user = User::searchEncrypted($email, ['email'])->first();

        if (!$user) {
            return app(FailedPasswordResetLinkRequestResponse::class, [
                'status' => Password::INVALID_USER
            ]);
        }

        // Use the encrypted email from database for password reset
        $status = Password::broker()->sendResetLink([
            Fortify::email() => $user->getRawOriginal('email')
        ]);

        return $status == Password::RESET_LINK_SENT
            ? app(SuccessfulPasswordResetLinkRequestResponse::class, ['status' => $status])
            : app(FailedPasswordResetLinkRequestResponse::class, ['status' => $status]);
    }
}
