<?php

use Vault\event\ExtensionHandler;

require_once __DIR__.'/data/const.php';
require_once __DIR__.'/settings.php';

if (ENV == DEV) {
    error_reporting(E_ALL);
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
require_once __DIR__.'/security/Whitelist.php';

require_once __DIR__.'/data/FileManager.php';
require_once __DIR__.'/data/DatabaseManager.php';
require_once __DIR__.'/data/DataManager.php';
require_once __DIR__.'/data/UserManager.php';
require_once __DIR__.'/data/SettingsManager.php';

require_once __DIR__.'/authentication/AuthenticationManager.php';
require_once __DIR__.'/authentication/TokenManager.php';
require_once __DIR__.'/authentication/SessionManager.php';

require_once __DIR__.'/event/ErrorHandler.php';
require_once __DIR__.'/event/ExtensionHandler.php';
require_once __DIR__.'/event/RequestHandler.php';
require_once __DIR__.'/event/RouteHandler.php';

require_once __DIR__.'/api/ApiError.php';

require_once __DIR__.'/libraries/PHPGangsta_GoogleAuthenticator.php';

$ext = new ExtensionHandler();
$ext->vaultStartup();

if (!file_exists(__DIR__.'/run.json') && !isset($setup) && !str_contains($_SERVER['REQUEST_URI'], '/api/status')) {
    require_once __DIR__.'/event/setup.php';
    exit;
}
