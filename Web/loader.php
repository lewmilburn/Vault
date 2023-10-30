<?php

require_once __DIR__.'/data/const.php';
require_once __DIR__.'/settings.php';

if (ENV == DEV) {
    error_reporting(-1);
} elseif (ENV == PROD) {
    error_reporting(0);
}

require_once __DIR__.'/encryption/encryptionManager.php';

require_once __DIR__.'/data/fileManager.php';
require_once __DIR__.'/data/databaseManager.php';
require_once __DIR__.'/data/dataManager.php';

require_once __DIR__.'/authentication/authenticationManager.php';
require_once __DIR__.'/authentication/tokenManager.php';

require_once __DIR__.'/event/errorHandler.php';

require_once __DIR__.'/event/routeHandler.php';

if (!extension_loaded('sodium'))
{
    $eh = new \Vault\event\errorHandler();
    $eh->error(null, null, null, 'Sodium not installed.', '500');
}