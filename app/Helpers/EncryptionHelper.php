<?php

namespace App\Helpers;

use Exception;
use Random\RandomException;

class EncryptionHelper
{
    protected static function getKey(): string
    {
        return config('encryption.key');
    }

    /**
     * @throws RandomException
     * @throws Exception
     */
    public static function secureString(string $input, string $action = 'encrypt'): string
    {
        $cipher = 'AES-256-CBC';
        $key = static::getKey();

        if ($action === 'encrypt') {
            $iv = random_bytes(openssl_cipher_iv_length($cipher));
            $encrypted = openssl_encrypt($input, $cipher, $key, 0, $iv);
            return base64_encode($iv . $encrypted);
        }

        if ($action === 'decrypt') {
            $decoded = base64_decode($input);
            $ivLength = openssl_cipher_iv_length($cipher);
            $iv = substr($decoded, 0, $ivLength);
            $cipherText = substr($decoded, $ivLength);
            return openssl_decrypt($cipherText, $cipher, $key, 0, $iv);
        }
        throw new Exception('Invalid action. Use "encrypt" or "decrypt".');
    }
}
