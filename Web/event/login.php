<?php

use Vault\authentication\authenticationManager;
use Vault\data\dataManager;
use Vault\inputManager;

if (!isset($_POST['user']) || !isset($_POST['pass'])) {
    header('Location: /');
    exit;
}

$am = new authenticationManager();
$dm = new dataManager();
$im = new inputManager();

$user = $im->escapeString($_POST['user']);
$pass = $im->escapeString($_POST['pass']);

if ($user == null || $pass == null) {
    header('Location: /');
    exit;
}

$am->login($user, $pass);

header('Location: /');
exit;