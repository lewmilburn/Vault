<?php

use event\RequestHandler;
use Vault\api\ApiError;
use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\security\InputManager;
use Vault\security\ValidationManager;

header('Content-Type: application/json; charset=utf-8');

$am = new AuthenticationManager();
$eh = new ApiError();

if ($am->authenticated() && isset($_SESSION['user'])) {
    $rh = new RequestHandler();
    $sentData = $rh->getJSONBody();

    $vm = new ValidationManager();

    if (!$sentData) {
        $eh->dataNotRecieved();
    } elseif (!isset($sentData->pid) || $vm->isEmpty($sentData->pid)) {
        $eh->missingData();
    } else {
        if (!isset($sentData->notes)) {
            $sentData->notes = null;
        }

        $dm = new DataManager();
        $im = new InputManager();

        if ($dm->deletePassword(
            $_SESSION['user'],
            $_SESSION['key'],
            $im->escapeString($sentData->pid)
        )) {
            echo '{"status": 200}';
        } else {
            $eh->internalServerError();
        }
    }
} else {
    $eh->unauthorised();
}
