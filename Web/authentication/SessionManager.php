<?php

namespace Vault\authentication;

class SessionManager
{
    public function active(): bool
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            return true;
        } else {
            return false;
        }
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
        if (isset($_SESSION['token']) && isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }
}
