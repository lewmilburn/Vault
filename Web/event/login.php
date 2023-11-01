<?php

use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\security\InputManager;

$homeLocation = 'Location: /';

if (!isset($_POST['user']) || !isset($_POST['pass'])) {
    header($homeLocation.'?lf=none');
    exit;
}

$am = new AuthenticationManager();
$dm = new DataManager();
$im = new InputManager();

$user = $im->escapeString($_POST['user']);
$pass = $im->escapeString($_POST['pass']);

if ($user == null || $pass == null) {
    header($homeLocation.'?lf=none');
    exit;
}

if ($am->login($user, $pass)) {
    header($homeLocation);
} else {
    header($homeLocation.'?lf=wrong');
}

header($homeLocation);
exit;
