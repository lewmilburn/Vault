<?php

use Vault\event\ErrorHandler;

require_once __DIR__.'/data/const.php';
require_once __DIR__.'/settings.php';

if (ENV == DEV) {
    error_reporting(-1);
} elseif (ENV == PROD) {
    error_reporting(0);
    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') {
        $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header('Location: '.$redirect);
        exit;
    }
}

require_once __DIR__.'/security/EncryptionManager.php';
require_once __DIR__.'/security/InputManager.php';
require_once __DIR__.'/security/HashManager.php';
require_once __DIR__.'/security/ValidationManager.php';

require_once __DIR__.'/data/FileManager.php';
require_once __DIR__.'/data/DatabaseManager.php';
require_once __DIR__.'/data/DataManager.php';

require_once __DIR__.'/authentication/AuthenticationManager.php';
require_once __DIR__.'/authentication/TokenManager.php';
require_once __DIR__.'/authentication/SessionManager.php';

require_once __DIR__.'/event/ErrorHandler.php';
require_once __DIR__.'/event/ExtensionHandler.php';

require_once __DIR__.'/event/RouteHandler.php';

$ext = new \Vault\event\ExtensionHandler();
$ext->vaultStartup();

if (!file_exists(__DIR__.'/run.json') && !isset($setup)) {
    require_once __DIR__.'/event/setup.php';
    exit;
}
