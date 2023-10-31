<?php

namespace Vault\authentication;

class SessionManager
{
    public function active(): bool
    {
        return session_status() == PHP_SESSION_ACTIVE;
    }

    public function end(): bool
    {
        if ($this->active()) {
            session_unset();
            session_destroy();

            return true;
        } else {
            return false;
        }
    }

    public function authTokens(): bool
    {
        return isset($_SESSION['token']) && isset($_SESSION['user']);
    }
}
