<?php

use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\security\InputManager;

header('Content-Type: application/json; charset=utf-8');

$am = new AuthenticationManager();
if ($am->authenticated() && isset($_SESSION['user'])) {
    $dm = new DataManager();
    $im = new InputManager();
    $user = $im->escapeString($_SESSION['user']);
    $key = $_SESSION['key'];

    $data = json_encode($dm->getVault($user, $key));
} else {
    $data = '{"status": 403}';
    http_response_code(403);
}

echo $data;
