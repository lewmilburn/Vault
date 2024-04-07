<?php

use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\Libraries\PHPGangsta_GoogleAuthenticator;
use Vault\security\InputManager;
use Vault\security\ValidationManager;

if (isset($_POST['user']) && isset($_POST['pass']) && ALLOW_REGISTRATION) {

    $factor = new PHPGangsta_GoogleAuthenticator();
    if (!$factor->verifyCode($_POST['secret'], $_POST['code'])) {
        header('Location: /register/?rf=code');
        exit;
    }

    $im = new InputManager();
    $user = $im->escapeString($_POST['user']);
    $pass = $im->escapeString($_POST['pass']);
    $code = $im->escapeString($_POST['code']);

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
    if (!$dm->createUser($user, $pass, 0, $_POST['secret'])) {
        header('Location: /register/?rf=userExists');
        exit;
    }

    $dm->createVault($user, $pass);

    $auth = new AuthenticationManager();
    $auth->login($user, $pass, $code);

    header('Location: /');
}
