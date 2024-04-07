<?php

namespace Vault\authentication;

use Vault\Data\DataManager;
use Vault\Event\ErrorHandler;
use Vault\Libraries\PHPGangsta_GoogleAuthenticator;
use Vault\security\EncryptionManager;

class AuthenticationManager
{
    public function login(string $username, string $password, int $code)
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

            $factor = new PHPGangsta_GoogleAuthenticator();

            if (!isset($user->secret)) {
                $eh = new ErrorHandler();
                $eh->error(
                    'Vault\authentication',
                    'AuthenticationManager',
                    'login',
                    'User secret is not defined.',
                    '500'
                );
            }

            if (!$factor->verifyCode($user->secret, $code)) {
                header('Location: /?lf=code');
                exit;
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
                $_SESSION['role'] = $user->role;

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
