<?php

use Vault\data\FileManager;

try {
    $tempPassword = random_int(100000, 999999);
} catch (Exception $e) {
    echo 'Unable to setup Vault. Fatal error: '.$e;
}

require_once __DIR__.'/../data/const.php';
require_once __DIR__.'/../Settings.php';
require_once __DIR__.'/../data/FileManager.php';
require_once __DIR__.'/../security/EncryptionManager.php';

$fm = new FileManager();
$fm->initialiseFileSystem($tempPassword);

file_put_contents(__DIR__.'/../run.json','{"config":true}');

header('Location: /?temp='.$tempPassword);