<?php

use Vault\api\ApiError;
use Vault\data\DataManager;
use Vault\security\EncryptionManager;
use Vault\security\InputManager;

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['user']) && isset($_GET['key'])) {
    $im = new InputManager();
    $user = $im->escapeString($_GET['user']);

    $dm = new DataManager();
    $em = new EncryptionManager();

    $user = $im->escapeString($_GET['user']);
    echo json_encode($dm->getVault($user, $_GET['key']));
} else {
    $eh = new ApiError();
    $eh->dataNotRecieved();
}
