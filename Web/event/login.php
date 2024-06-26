<?php

use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\security\InputManager;
use Vault\security\ValidationManager;

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
$code = $im->escapeString($_POST['code']);
$token = $im->escapeString($_POST['csrf']);

/*$vm = new ValidationManager();
if (!$vm->csrfValidate($token)) {
    header($homeLocation.'?lf=csrf');
    exit;
}*/

if ($user == null || $pass == null) {
    header($homeLocation.'?lf=none');
    exit;
}

if ($am->login($user, $pass, (int) $code)) {
    header($homeLocation);
    exit;
} else {
    header($homeLocation.'?lf=wrong');
    exit;
}

header($homeLocation);
exit;
