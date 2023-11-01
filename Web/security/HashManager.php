<?php

namespace Vault\security;

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

    public function generateChecksum($string)
    {
        return hash('sha1', $string);
    }
}