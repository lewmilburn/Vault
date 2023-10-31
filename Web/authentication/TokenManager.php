<?php

namespace Vault\authentication;

class TokenManager
{
    public function generateToken(string $uuid): string
    {
        return hash('sha3-512', $uuid.date('Y-m-d'));
    }

    public function validToken(string $token, string $user): string
    {
        if ($token == hash('sha3-512', $user.date('Y-m-d'))) {
            return true;
        } else {
            return false;
        }
    }
}
