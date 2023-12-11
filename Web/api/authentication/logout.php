<?php

use Vault\api\ApiError;
use Vault\authentication\AuthenticationManager;

header('Content-Type: application/json; charset=utf-8');

$am = new AuthenticationManager();
$eh = new ApiError();

if (!$am->authenticated() && isset($_SESSION['user'])) {
    $am = new AuthenticationManager();
    $am->logout();
    echo '{"status": 200}';
} else {
    $eh->unauthorised();
}
