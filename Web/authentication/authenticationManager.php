<?php

namespace Vault\Authentication;

use Vault\Data\dataManager;

class authenticationManager {
    public function Login(string $username, string $password) {
        $data = new dataManager();
        $data->getUserData($username);
    }
}