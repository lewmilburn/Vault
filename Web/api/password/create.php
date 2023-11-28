<?php

use Vault\data\DataManager;
use Vault\security\HashManager;

$hm = new HashManager();

$dm = new DataManager();
$dm->addPassword(
    $_SESSION['user'],
    $_SESSION['key'],
    $hm->generateUniqueId(),
    $_POST['user'],
    $_POST['pass'],
    $_POST['name'],
    $_POST['url'],
    $_POST['notes']
);

header('Location: /');
exit;
