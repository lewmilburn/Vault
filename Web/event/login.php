<?php

use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\InputManager;

$failLocation = 'Location: /';

if (!isset($_POST['user']) || !isset($_POST['pass'])) {
    header($failLocation);
    exit;
}

$am = new AuthenticationManager();
$dm = new DataManager();
$im = new InputManager();

$user = $im->escapeString($_POST['user']);
$pass = $im->escapeString($_POST['pass']);

if ($user == null || $pass == null) {
    header($failLocation);
    exit;
}

$am->login($user, $pass);

header($failLocation);
exit;
