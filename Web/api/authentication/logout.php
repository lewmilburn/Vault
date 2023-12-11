<?php

use event\RequestHandler;
use Vault\api\ApiError;
use Vault\authentication\AuthenticationManager;
use Vault\security\ValidationManager;

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
