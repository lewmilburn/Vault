<?php

namespace Vault\authentication;

class TokenManager
{
    public function generateToken(string $uuid): string
    {
        return hash(DEFAULT_HASH, $uuid.date('Y-m-d'));
    }

    public function validToken(string $token, string $user): string
    {
        return $token == hash(DEFAULT_HASH, $user.date('Y-m-d'));
    }
}
