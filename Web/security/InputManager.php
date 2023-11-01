<?php

namespace Vault\security;

class InputManager
{
    public function escapeString(string $string): string
    {
        return htmlspecialchars($string);
    }

    public function validatePasswordStrength(string $password): bool
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            return false;
        } else {
            return true;
        }
    }
}
