<?php

namespace App\Auth;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Arr;

class EncryptedPasswordBroker extends PasswordBroker
{
    public function getUser(array $credentials)
    {
        $credentials = Arr::except($credentials, ['token']);

        $user = $this->users->retrieveByCredentials($credentials);

        if ($user && !$user instanceof CanResetPassword) {
            throw new \UnexpectedValueException('User must implement CanResetPassword interface.');
        }

        return $user;
    }
}
