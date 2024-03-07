<?php

use event\RequestHandler;
use Vault\api\ApiError;
use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\data\UserManager;
use Vault\security\HashManager;
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
    } elseif (
        (!isset($sentData->data->user) || $vm->isEmpty($sentData->data->user)) ||
        (!isset($sentData->data->pass) || $vm->isEmpty($sentData->data->pass)) ||
        (!isset($sentData->data->name) || $vm->isEmpty($sentData->data->name)) ||
        (!isset($sentData->data->url) || $vm->isEmpty($sentData->data->url))
    ) {
        $eh->missingData();
    } else {
        $sentData->data->notes = $eh->notesNull($sentData->data->notes);

        $hm = new HashManager();
        $dm = new DataManager();
        $im = new InputManager();

        if (isset($sentData->user) && isset($sentData->key) && !$am->authenticated()) {
            $user = $sentData->user;
            $key = urldecode($sentData->key);
        } else {
            $user = $_SESSION['user'];
            $key = $_SESSION['key'];
        }

        if ($dm->addPassword(
            $im->escapeString($user),
            $key,
            $hm->generateUniqueId(),
            $im->escapeString($sentData->data->user),
            $im->escapeString($sentData->data->pass),
            $im->escapeString($sentData->data->name),
            $im->escapeString($sentData->data->url),
            $im->escapeString($sentData->data->notes)
        )) {
            $um = new UserManager();
            $um->setLastChange($_GET['user']);
            echo '{"status": 200}';
        } else {
            $eh->internalServerError();
        }
    }
} else {
    $eh->unauthorised();
}
