<?php

use event\RequestHandler;
use Vault\api\ApiError;
use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\data\UserManager;
use Vault\security\InputManager;
use Vault\security\ValidationManager;

header('Content-Type: application/json; charset=utf-8');

$am = new AuthenticationManager();
$eh = new ApiError();

$rh = new RequestHandler();
$sentData = $rh->getJSONBody();

if ($am->authenticated() || (isset($sentData->user) && isset($sentData->key))) {
    $vm = new ValidationManager();

    if (!$sentData) {
        $eh->dataNotRecieved();
    } elseif (!isset($sentData->data->pid) || $vm->isEmpty($sentData->data->pid)) {
        $eh->missingData();
    } else {
        if (isset($sentData->user) && isset($sentData->key) && !$am->authenticated()) {
            $user = $sentData->user;
            $key = urldecode($sentData->key);
        } else {
            $user = $_SESSION['user'];
            $key = $_SESSION['key'];
        }

        $dm = new DataManager();
        $im = new InputManager();

        if ($dm->deletePassword(
            $im->escapeString($user),
            $key,
            $im->escapeString($sentData->data->pid)
        )) {
            $um = new UserManager();
            $timestamp = strtotime($sentData->time.'+0 hour');
            $um->setLastChange($sentData->user, date('Y-m-d H:i', $timestamp));
            echo '{"status": 200}';
        } else {
            $eh->internalServerError();
        }
    }
} else {
    $eh->unauthorised();
}
