<?php

use event\RequestHandler;
use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\event\ErrorHandler;
use Vault\security\InputManager;
use Vault\security\ValidationManager;

header('Content-Type: application/json; charset=utf-8');

$am = new AuthenticationManager();
if ($am->authenticated() && isset($_SESSION['user'])) {
    $rh = new RequestHandler();
    $sentData = $rh->getJSONBody();

    $vm = new ValidationManager();

    if ($sentData == null | $sentData == false) {
        $eh = new ErrorHandler();
        $eh->error('', '', '', 'Required data not recieved.', 400);
    } elseif (
        (!isset($sentData->pid) || $vm->isEmpty($sentData->pid)) ||
        (!isset($sentData->user) || $vm->isEmpty($sentData->user)) ||
        (!isset($sentData->pass) || $vm->isEmpty($sentData->pass)) ||
        (!isset($sentData->name) || $vm->isEmpty($sentData->name)) ||
        (!isset($sentData->url) || $vm->isEmpty($sentData->url))
    )
    {
        $eh = new ErrorHandler();
        $eh->error('', '', '', 'Missing required data.', 400);
    } else {
        if (!isset($sentData->notes)) {
            $sentData->notes = null;
        }

        $dm = new DataManager();
        $im = new InputManager();

        if ($dm->updatePassword(
            $_SESSION['user'],
            $_SESSION['key'],
            $im->escapeString($sentData->pid),
            $im->escapeString($sentData->user),
            $im->escapeString($sentData->pass),
            $im->escapeString($sentData->name),
            $im->escapeString($sentData->url),
            $im->escapeString($sentData->notes)
        )) {
            echo '{"status": 200}';
        } else {
            $eh = new ErrorHandler();
            $eh->error('', '', '', 'Internal Server Error.', 500);
        }
    }
} else {
    $eh = new ErrorHandler();
    $eh->unauthorised();
}