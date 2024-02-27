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
    $vm = new \Vault\security\ValidationManager();

    $user = $im->escapeString($_GET['user']);
    $vault = $dm->getVault($user, $_GET['key']);
    $vault = [
        'data'               => $vault,
        'last_known_checksum'=> $vm->generateChecksum(json_encode($vault)),
    ];

    echo json_encode($vault);
} else {
    $eh = new ApiError();
    $eh->dataNotRecieved();
}
