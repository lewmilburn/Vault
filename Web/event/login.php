<?php

use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\InputManager;

if (!isset($_POST['user']) || !isset($_POST['pass'])) {
    header('Location: /');
    exit;
}

$am = new AuthenticationManager();
$dm = new DataManager();
$im = new InputManager();

$user = $im->escapeString($_POST['user']);
$pass = $im->escapeString($_POST['pass']);

if ($user == null || $pass == null) {
    header('Location: /');
    exit;
}

$am->login($user, $pass);

header('Location: /');
exit;
