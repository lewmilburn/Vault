<?php

namespace Vault\security;

use Exception;
use Vault\event\ErrorHandler;

class ValidationManager
{
    /**
     * Validates a password.
     *
     * @param string $password
     *
     * @return bool
     */
    public function validatePasswordStrength(string $password): bool
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Generates a CSRF token.
     *
     * @return string
     */
    public function csrfToken(): string
    {
        $hm = new HashManager();

        try {
            $token = $hm->hashString(uniqid(random_bytes(1000), true));
        } catch (Exception $e) {
            $em = new ErrorHandler();
            $em->error(
                'security',
                'ValidationManager',
                'csrfToken',
                'Unexpected error: '.$e,
                '500'
            );
        }

        $_SESSION['csrf'] = $token;

        return $token;
    }

    /**
     * Validates a CSRF token and clears it from the session.
     *
     * @param $token
     *
     * @return string
     */
    public function csrfValidate($token): string
    {
        if ($token == $_SESSION['csrf']) {
            unset($_SESSION['csrf']);

            return true;
        } else {
            return false;
        }
    }
}
