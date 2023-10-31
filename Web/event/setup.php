<?php

$tempPassword = 'Vault123!';

require_once __DIR__.'/../data/const.php';
require_once __DIR__.'/../Settings.php';
require_once __DIR__.'/../data/FileManager.php';
require_once __DIR__.'/../security/EncryptionManager.php';

$fm = new \Vault\data\FileManager();
$fm->initialiseFileSystem($tempPassword);

file_put_contents(__DIR__.'/../run.json','{"config":true}');

header('Location: /?temp='.$tempPassword);