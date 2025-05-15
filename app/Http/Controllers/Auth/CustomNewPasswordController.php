<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\FailedPasswordResetResponse;
use Laravel\Fortify\Contracts\PasswordResetResponse;
use Laravel\Fortify\Fortify;

class CustomNewPasswordController extends \Illuminate\Routing\Controller
{
    public function store(Request $request)
    {
        $request->validate([
            Fortify::email() => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $email = $request->{Fortify::email()};

        if (config('fortify.lowercase_usernames')) {
            $email = Str::lower($email);
        }

        // 🔒 Search user with encrypted email
        $user = User::searchEncrypted($email, ['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                Fortify::email() => [trans(Password::INVALID_USER)],
            ]);
        }

        // Use raw original email to reset password
        $status = Password::broker()->reset(
            [
                'email' => $user->getRawOriginal('email'),
                'token' => $request->token,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? app(PasswordResetResponse::class, ['status' => $status])
            : app(FailedPasswordResetResponse::class, ['status' => $status]);
    }
}
