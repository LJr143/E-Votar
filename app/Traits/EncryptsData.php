<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\EncryptException;

trait EncryptsData
{
    /**
     * Decrypt fields when retrieving from database
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->getEncryptedFields()) && !empty($value)) {
            try {
                return Crypt::decrypt($value);
            } catch (EncryptException $e) {
                return $value;
            }
        }

        return $value;
    }

    /**
     * Encrypt fields when saving to database
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->getEncryptedFields()) && !empty($value)) {
            $value = Crypt::encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Get the encrypted fields for this model
     */
    protected function getEncryptedFields()
    {
        return property_exists($this, 'encryptedFields') ? $this->encryptedFields : [];
    }

    /**
     * Special method for searching encrypted fields with exact match
     */
    public function scopeWhereEncrypted($query, $field, $value)
    {
        if (in_array($field, $this->getEncryptedFields())) {
            return $query->where($field, Crypt::encrypt($value));
        }

        return $query->where($field, $value);
    }

    /**
     * Search encrypted fields with partial matching (decrypts first)
     */
    public function scopeSearchEncrypted($query, string $searchTerm, array $fields = [])
    {
        $fields = empty($fields) ? $this->getEncryptedFields() : $fields;
        $searchTerm = strtolower($searchTerm);

        // First get all potential matches
        $results = $query->where(function($q) use ($fields) {
            foreach ($fields as $field) {
                $q->orWhereNotNull($field);
            }
        })->get();

        // Then filter by decrypted values
        return $results->filter(function($item) use ($fields, $searchTerm) {
            foreach ($fields as $field) {
                $decryptedValue = strtolower($item->$field); // Automatically decrypted by getAttribute
                if (str_contains($decryptedValue, $searchTerm)) {
                    return true;
                }
            }
            return false;
        });
    }

    /**
     * Case-insensitive search helper
     */
    public function scopeWhereEncryptedLike($query, $field, $value)
    {
        if (!in_array($field, $this->getEncryptedFields())) {
            return $query->where($field, 'like', '%'.$value.'%');
        }

        return $query->where(function($q) use ($field, $value) {
            $q->whereNotNull($field)
                ->where(function($q) use ($field, $value) {
                    $q->whereRaw('LOWER(?) LIKE ?', [
                        Crypt::decrypt($field),
                        '%'.strtolower($value).'%'
                    ]);
                });
        });
    }
}
