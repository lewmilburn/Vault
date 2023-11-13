<?php

namespace Vault\security;

use SodiumException;
use Vault\event\ErrorHandler;

class EncryptionManager
{
    public function generateKey($user, $password): string
    {
        $vm = new ValidationManager();
        $vm->throwNull($user);
        $vm->throwNull($password);

        try {
            return sodium_crypto_pwhash(
                SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES,
                $password,
                $this->generateSalt($user),
                SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
                SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
            );
        } catch (SodiumException $e) {
            $eh = new ErrorHandler();
            $eh->error('security', 'encryptionManager', 'encrypt', $e, '500');
        }
    }

    public function encrypt($string, $key): array
    {
        $vm = new ValidationManager();
        $vm->throwNull($string);
        $vm->throwNull($key);

        try {
            $nonce = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
            $encryptedData = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt(
                $string,
                '',
                $nonce,
                $key
            );

            // Overwriting memory to prevent data leakage
            sodium_memzero($string);
            sodium_memzero($key);

            return [$encryptedData, $nonce];
        } catch (SodiumException|\Exception $e) {
            $eh = new ErrorHandler();
            $eh->error(
                'security',
                'encryptionManager',
                'encrypt',
                $e,
                '500'
            );
        }
    }

    public function decrypt(string $data, string $key): string|null
    {
        $vm = new ValidationManager();
        $vm->throwNull($data);
        $vm->throwNull($key);

        $data = explode(FILE_SEPARATOR, $data);
        $encryptedData = $data[0];
        $nonce = $data[1];

        try {
            $decryptedData = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt(
                $encryptedData,
                '',
                $nonce,
                $key
            );

            // Overwriting memory to prevent data leakage
            sodium_memzero($string);
            sodium_memzero($nonce);
            sodium_memzero($key);

            return $decryptedData;
        } catch (SodiumException|\Exception $e) {
            $eh = new ErrorHandler();
            $eh->error(
                'security',
                'encryptionManager',
                'decrypt',
                $e,
                '500'
            );
        }
    }

    private function generateSalt($user): string
    {
        $vm = new ValidationManager();
        $vm->throwNull($user);

        return str_pad(
            $user,
            SODIUM_CRYPTO_PWHASH_SALTBYTES,
            "_",
            STR_PAD_RIGHT
        );
    }
}
