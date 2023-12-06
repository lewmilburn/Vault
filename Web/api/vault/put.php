<?php

use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\security\InputManager;

header('Content-Type: application/json; charset=utf-8');

$am = new AuthenticationManager();
if ($am->authenticated() && isset($_SESSION['user'])) {
    $sentData = json_decode(file_get_contents("php://input"));

    if ($sentData == null | $sentData == false) {
        $data = '{"status": 400, "error": "No data sent"}';
        http_response_code(400);
    } else {
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
        http_response_code(200);
    }
} else {
    $data = '{"status": 401, "error": "Unauthorized"}';
    http_response_code(403);
}

echo $data;
