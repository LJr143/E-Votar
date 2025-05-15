<?php
// app/Auth/EncryptedUserProvider.php
namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Crypt;

class EncryptedUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        $model = $this->createModel();

        foreach ($credentials as $key => $value) {
            if ($key === 'password') {
                continue;
            }

            if (method_exists($model, 'scopeWhereEncrypted')) {
                return $model->whereEncrypted($key, $value)->first();
            }

            return $model->where($key, $value)->first();
        }

        return null;
    }
}
