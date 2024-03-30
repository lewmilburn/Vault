<?php

namespace Vault\security;

use Exception;
use Vault\event\ErrorHandler;

class HashManager
{
    public function hashString($string)
    {
        return hash(DEFAULT_HASH, $string);
    }

    public function hashUser($string)
    {
        return hash(USER_HASH, $string);
    }

    public function generateUniqueId()
    {
        try {
            return hash(USER_HASH, random_bytes(16));
        } catch (Exception $e) {
            $eh = new ErrorHandler();
            $eh->error(
                'security',
                'HashManager',
                'generateUniqueHash',
                $e,
                '500'
            );
        }
    }

    public function generateChecksum($string): string
    {
        return hash(CHECKSUM_HASH, $string);
    }
}
