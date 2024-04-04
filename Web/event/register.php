<?php

use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\security\InputManager;
use Vault\security\ValidationManager;

if (isset($_POST['user']) && isset($_POST['pass']) && ALLOW_REGISTRATION) {

    $im = new InputManager();
    $user = $im->escapeString($_POST['user']);
    $pass = $im->escapeString($_POST['pass']);

    $user = trim($user);
    $pass = trim($pass);

    $vm = new ValidationManager();
    if (!$vm->validatePasswordStrength($pass)) {
        header('Location: /register/?rf=pass');
        exit;
    }

    if (!$vm->validateUsername($user)) {
        header('Location: /register/?rf=user');
        exit;
    }

    $dm = new DataManager();
    if (!$dm->createUser($user,$pass,0)) {
        header('Location: /register/?rf=userExists');
        exit;
    }

    $dm->createVault($user, $pass);
    
    $auth = new AuthenticationManager();
    $auth->login($user, $pass);

    header('Location: /');
}
