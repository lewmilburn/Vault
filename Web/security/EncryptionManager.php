<?php

namespace Vault\security;

use SodiumException;
use Vault\event\ErrorHandler;

class EncryptionManager
{
    public function generateKey($password): string
    {
        try {
            return sodium_crypto_pwhash(SODIUM_CRYPTO_SECRETBOX_KEYBYTES, $password, '0000000000000000', SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13);
        } catch (SodiumException $e) {
            $eh = new ErrorHandler();
            $eh->error('security', 'encryptionManager', 'encrypt', $e, '500');
            exit;
        }
    }

    public function encrypt($string, $key): array
    {
        try {
            $nonce = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
            $encryptedData = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($string, '', $nonce, $key);

            // Overwriting memory to prevent data leakage
            sodium_memzero($string);
            sodium_memzero($key);

            return [$encryptedData, $nonce];
        } catch (SodiumException|\Exception $e) {
            $eh = new ErrorHandler();
            $eh->error('security', 'encryptionManager', 'encrypt', $e, '500');
            exit;
        }
    }

    public function decrypt($string, $key, $nonce): string|null
    {
        try {
            $decryptedData = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($string, '', $nonce, $key);

            // Overwriting memory to prevent data leakage
            sodium_memzero($string);
            sodium_memzero($nonce);
            sodium_memzero($key);

            return $decryptedData;
        } catch (SodiumException|\Exception $e) {
            $eh = new ErrorHandler();
            $eh->error('security', 'encryptionManager', 'decrypt', $e, '500');
            exit;
        }
    }
}
