<?php

use Vault\event\ErrorHandler;

require_once __DIR__.'/data/const.php';
require_once __DIR__.'/settings.php';

if (ENV == DEV) {
    error_reporting(-1);
} elseif (ENV == PROD) {
    error_reporting(0);
}

require_once __DIR__.'/security/EncryptionManager.php';
require_once __DIR__.'/security/InputManager.php';

require_once __DIR__.'/data/FileManager.php';
require_once __DIR__.'/data/DatabaseManager.php';
require_once __DIR__.'/data/DataManager.php';

require_once __DIR__.'/authentication/AuthenticationManager.php';
require_once __DIR__.'/authentication/TokenManager.php';
require_once __DIR__.'/authentication/SessionManager.php';

require_once __DIR__.'/event/ErrorHandler.php';

require_once __DIR__.'/event/RouteHandler.php';

if (!extension_loaded('sodium')) {
    $eh = new ErrorHandler();
    $eh->error(null, null, null, 'Sodium not installed.', '500');
}
