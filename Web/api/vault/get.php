<?php

use Vault\api\ApiError;
use Vault\data\DataManager;
use Vault\data\UserManager;
use Vault\security\EncryptionManager;
use Vault\security\HashManager;
use Vault\security\InputManager;
use Vault\security\ValidationManager;

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['user']) && isset($_GET['key'])) {
    $im = new InputManager();
    $user = $im->escapeString($_GET['user']);

    $um = new UserManager();
    if (isset($_GET['sync'])) {
        $um->setLastSync($_GET['user']);
    }

    $dm = new DataManager();
    $em = new EncryptionManager();
    $hm = new HashManager();

    $user = $im->escapeString($_GET['user']);
    $vault = $dm->getVault($user, $_GET['key']);
    $vault = [
        'data'        => $vault,
        'checksum'    => $hm->generateChecksum(json_encode($vault)),
        'last_change' => $um->getLastChange($_GET['user']),
    ];

    echo json_encode($vault);
} else {
    $eh = new ApiError();
    $eh->dataNotRecieved();
}
