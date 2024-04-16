<?php

use Vault\api\ApiError;
use Vault\data\DataManager;
use Vault\data\UserManager;
use Vault\security\EncryptionManager;
use Vault\security\HashManager;
use Vault\security\InputManager;

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['user']) && isset($_GET['key'])) {
    $im = new InputManager();
    $user = $im->escapeString($_GET['user']);

    $um = new UserManager();
    if (isset($_GET['sync'])) {
        $um->setLastChange($user, $im->escapeString($_GET['sync']));
    }

    $dm = new DataManager();
    $em = new EncryptionManager();
    $hm = new HashManager();

    $vault = $dm->getVault($user, $_GET['key']);

    $arrayVault = [];
    $i = 0;
    foreach ($vault as $item) {
        $arrayVault[$i] = $item;
        $i++;
    }

    $vault = [
        'data'        => $arrayVault,
        'checksum'    => $hm->generateChecksum(json_encode($vault)),
        'last_change' => $um->getLastChange($user),
    ];

    echo json_encode($vault);
} else {
    $eh = new ApiError();
    $eh->dataNotRecieved();
}
