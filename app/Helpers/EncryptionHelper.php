<?php
namespace App\Helpers;

use Exception;

class EncryptionHelper
{
    private static $key;
    private static $cipher = 'aes-256-cbc';

    /**
     * Set the encryption key.
     *
     * @param string $key The encryption key.
     * @return void
     */
    public static function setKey(string $key): void
    {
        self::$key = $key;
    }

    /**
     * Encrypt data using AES-256-CBC.
     *
     * @param string $data The data to encrypt.
     * @return string The encrypted data.
     * @throws Exception
     */
    public static function encrypt(string $data): string
    {
        if (empty(self::$key)) {
            throw new Exception("Encryption key is not set.");
        }

        $ivLength = openssl_cipher_iv_length(self::$cipher);
        $iv = random_bytes($ivLength);

        $encryptedData = openssl_encrypt($data, self::$cipher, self::$key, 0, $iv);

        return base64_encode($iv . $encryptedData);
    }

    /**
     * Decrypt data using AES-256-CBC.
     *
     * @param string $data The encrypted data.
     * @return string The decrypted data.
     * @throws Exception
     */
    public static function decrypt(string $data): string
    {
        if (empty(self::$key)) {
            throw new Exception("Encryption key is not set.");
        }

        $data = base64_decode($data);

        $ivLength = openssl_cipher_iv_length(self::$cipher);
        $iv = substr($data, 0, $ivLength);
        $encryptedData = substr($data, $ivLength);

        $decrypted = openssl_decrypt($encryptedData, self::$cipher, self::$key, 0, $iv);

        if ($decrypted === false) {
            throw new Exception("Decryption failed. Possible corruption in the data.");
        }

        return $decrypted;
    }
}
