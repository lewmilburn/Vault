<?php

use event\RequestHandler;
use Vault\api\ApiError;
use Vault\authentication\AuthenticationManager;
use Vault\security\ValidationManager;

header('Content-Type: application/json; charset=utf-8');

$am = new AuthenticationManager();
$eh = new ApiError();

if (!$am->authenticated() && isset($_SESSION['user'])) {
    $rh = new RequestHandler();
    $sentData = $rh->getJSONBody();

    $vm = new ValidationManager();

    if (!$sentData) {
        $eh->dataNotRecieved();
    } elseif (
        (!isset($sentData->username) || $vm->isEmpty($sentData->username)) ||
        (!isset($sentData->password) || $vm->isEmpty($sentData->password))
    ) {
        $eh->missingData();
    } else {
        $am = new AuthenticationManager();
        if ($am->login(
            $sentData->username,
            $sentData->password
        )) {
            echo '{"status": 200}';
        } else {
            $eh->internalServerError();
        }
    }
} else {
    $eh->alreadyAuthenticated();
}
