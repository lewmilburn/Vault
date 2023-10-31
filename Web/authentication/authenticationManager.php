<?php

namespace Vault\authentication;

use Vault\Data\dataManager;
use Vault\Event\errorHandler;

class authenticationManager
{
    public function login(string $username, string $password)
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            $data = new dataManager();
            $user = $data->getUserData($username);
            if (password_verify($password, $user->passkey)) {
                $tm = new tokenManager();
                $token = $tm->generateToken($user->user);
                $_SESSION['user'] = $user->user;
                $_SESSION['token'] = $token;

                return true;
            } else {
                return false;
            }
        } else {
            $eh = new errorHandler();
            $eh->sessionRequired('authentication', 'authenticationManager', 'Login');
            exit;
        }
    }

    public function logout()
    {
        $sm = new sessionManager();
        if ($sm->end()) {
            header('Location: /');
            exit;
        }
    }

    public function authenticated()
    {
        $sm = new sessionManager();
        $tm = new tokenManager();
        if ($sm->authTokens() && $tm->validToken($_SESSION['token'], $_SESSION['user'])) {
            return true;
        }
    }
}
