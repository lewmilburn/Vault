<?php

use event\RequestHandler;
use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\event\ErrorHandler;

header('Content-Type: application/json; charset=utf-8');

$am = new AuthenticationManager();
if ($am->authenticated() && isset($_SESSION['user'])) {
    $rh = new RequestHandler();
    $sentData = $rh->getJSONBody();

    if ($sentData == null | $sentData == false) {
        $eh = new ErrorHandler();
        $eh->error('', '', '', 'Missing required data.', 400);
    } elseif (
        !isset($sentData->pid) ||
        !isset($sentData->user) ||
        !isset($sentData->pass) ||
        !isset($sentData->name) ||
        !isset($sentData->url))
    {
        $eh = new ErrorHandler();
        $eh->error('', '', '', 'Missing required data.', 400);
    } else {
        if (!isset($sentData->notes)) {
            $sentData->notes = null;
        }

        $dm = new DataManager();
        $dm->updatePassword(
            $_SESSION['user'],
            $_SESSION['key'],
            $sentData->pid,
            $sentData->user,
            $sentData->pass,
            $sentData->name,
            $sentData->url,
            $sentData->notes
        );

        $data = '{"status": 200}';
    }
} else {
    $eh = new ErrorHandler();
    $eh->unauthorised();
}

echo $data;
