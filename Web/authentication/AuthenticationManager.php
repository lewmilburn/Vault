<?php

namespace Vault\authentication;

use Vault\Data\DataManager;
use Vault\Event\ErrorHandler;
use Vault\security\EncryptionManager;

class AuthenticationManager
{
    public function login(string $username, string $password)
    {
        if ($username == null || $password == null) {
            return false;
        }

        if (session_status() == PHP_SESSION_ACTIVE) {
            $data = new DataManager();
            $user = $data->getUserData($username);

            if ($user == null) {
                return false;
            }

            if (password_verify($password, $user->pass)) {
                $tm = new TokenManager();
                $token = $tm->generateToken($user->user);

                $em = new EncryptionManager();
                $key = $em->generateKey($user->user, $password);

                $_SESSION['name'] = $username;
                $_SESSION['user'] = $user->user;
                $_SESSION['pass'] = $password;
                $_SESSION['token'] = $token;
                $_SESSION['key'] = $key;

                $result = true;
            } else {
                $result = false;
            }

            return $result;
        } else {
            $eh = new ErrorHandler();
            $eh->sessionRequired('authentication', 'authenticationManager', 'Login');
        }
    }

    public function logout(): void
    {
        $sm = new SessionManager();
        if ($sm->end()) {
            header('Location: /');
            exit;
        }
    }

    public function authenticated(): bool
    {
        $sm = new SessionManager();
        $tm = new TokenManager();

        return $sm->authTokens() && $tm->validToken($_SESSION['token'], $_SESSION['user']);
    }
}
