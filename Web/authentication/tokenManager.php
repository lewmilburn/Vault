<?php

namespace Vault\Authentication;

class tokenManager
{
    public function generateToken(string $uuid): string
    {
        return hash('sha3-512', $uuid.date('Y-m-d'));
    }

    public function validateToken(string $token, string $uuid): string
    {
        if ($token == hash('sha3-512', $uuid.date('Y-m-d'))) {
            return true;
        } else {
            return false;
        }
    }
}
