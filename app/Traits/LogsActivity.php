<?php

namespace App\Traits;

use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        foreach (['created', 'updated', 'deleted'] as $event) {
            static::$event(function ($model) use ($event) {
                $description = ucfirst($event) . ' ' . class_basename($model);

                $data = [];
                if ($event === 'updated') {
                    $dirty = $model->getDirty();
                    $data['changes'] = collect($dirty)->map(function ($value, $key) use ($model) {
                        // Use self:: instead of $this->
                        $oldValue = self::decryptIfEncrypted($model, $model->getOriginal($key), $key);
                        $newValue = self::decryptIfEncrypted($model, $value, $key);

                        return [
                            'field' => $key,
                            'old' => $oldValue,
                            'new' => $newValue
                        ];
                    })->values()->toArray();
                } elseif ($event === 'created') {
                    $data['attributes'] = collect($model->getAttributes())->mapWithKeys(function ($value, $key) use ($model) {
                        return [$key => self::decryptIfEncrypted($model, $value, $key)];
                    })->toArray();
                }

                ActivityLogger::log(
                    action: $event,
                    description: $description,
                    model: $model,
                    data: $data
                );
            });
        }
    }

    /**
     * Decrypt the value if it belongs to an encrypted field
     */
    protected static function decryptIfEncrypted($model, $value, $field)
    {
        // Check if model uses EncryptsData trait and field is encrypted
        if (method_exists($model, 'getEncryptedFields')) {
            $encryptedFields = $model->getEncryptedFields();
            if (in_array($field, $encryptedFields)) {
                try {
                    return Crypt::decrypt($value);
                } catch (DecryptException $e) {
                    return '[Encrypted - Decryption Failed]';
                }
            }
        }

        return $value;
    }

    /**
     * Determine if a field should have its value hidden in logs
     */
    protected static function shouldHideValue($model, $field)
    {
        if (property_exists($model, 'sensitiveFields')) {
            return in_array($field, $model->sensitiveFields);
        }
        return false;
    }
}
