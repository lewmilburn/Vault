<?php

use event\RequestHandler;
use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\event\ErrorHandler;
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
    } elseif ((!isset($sentData->pid) || $vm->isEmpty($sentData->pid))) {
        $eh = new ErrorHandler();
        $eh->error('', '', '', 'Missing required data.', 400);
    } else {
        if (!isset($sentData->notes)) {
            $sentData->notes = null;
        }

        $dm = new DataManager();
        $dm->deletePassword(
            $_SESSION['user'],
            $_SESSION['key'],
            $sentData->pid
        );

        echo '{"status": 200}';
    }
} else {
    $eh = new ErrorHandler();
    $eh->unauthorised();
}