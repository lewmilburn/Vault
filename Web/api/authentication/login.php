<?php

use event\RequestHandler;
use Vault\api\ApiError;
use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\Libraries\PHPGangsta_GoogleAuthenticator;
use Vault\security\InputManager;
use Vault\security\ValidationManager;

header('Content-Type: application/json; charset=utf-8');

$am = new AuthenticationManager();
$eh = new ApiError();

if (!$am->authenticated() && !isset($_SESSION['user'])) {
    $rh = new RequestHandler();
    $sentData = $rh->getJSONBody();

    $vm = new ValidationManager();

    if (!$sentData) {
        $eh->dataNotRecieved();
    } elseif (
        (!isset($sentData->username) || $vm->isEmpty($sentData->username)) ||
        (!isset($sentData->password) || $vm->isEmpty($sentData->password)) ||
        (!isset($sentData->code) || $vm->isEmpty($sentData->code))
    ) {
        $eh->missingData();
    } else {
        $factor = new PHPGangsta_GoogleAuthenticator();
        $factorData = new DataManager();
        $factorData = $factorData->getUserData($sentData->username);

        if (!$factor->verifyCode($factorData->secret, $sentData->code)) {
            echo '{"status": 403, "error": "Two-factor authentication code does not match."}';
            exit;
        }

        unset($factorData);

        $im = new InputManager();
        $am = new AuthenticationManager();
        if ($am->login(
            $im->escapeString($sentData->username),
            $im->escapeString($sentData->password),
            $im->escapeString($sentData->code)
        )) {
            if (isset($sentData->sendall)) {
                echo '{"status": 200, "name": "'.$_SESSION['name'].'", "user": "'.$_SESSION['user'].'", "token": "'.$_SESSION['token'].'", "apikey": "'.urlencode($_SESSION['key']).'"}';
            } else {
                echo '{"status": 200, "user": "'.$_SESSION['user'].'"}';
            }
        } else {
            $eh->internalServerError();
        }
    }
} else {
    $eh->alreadyAuthenticated();
}
