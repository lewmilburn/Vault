<?php

namespace Vault\Authentication;

use mysql_xdevapi\Exception;
use Vault\Data\dataManager;

class authenticationManager {
    public function Login(string $username, string $password) {
        if (session_status() == PHP_SESSION_ACTIVE) {
            $data = new dataManager();
            $user = $data->getUserData($username);
            if (password_verify($password, $user->password)) {
                $tm = new tokenManager();
                $token = $tm->generateToken($user->uuid);
                $_SESSION['uuid'] = $user->uuid;
                $_SESSION['token'] = $token;
                return true;
            } else {
                return false;
            }
        } else {
            throw new Exception('No active session.');
        }
    }

    public function Logout() {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
            return true;
        } else {
            throw new Exception('No active session.');
        }
    }
}