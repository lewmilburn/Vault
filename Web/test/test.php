<?php

use Vault\test\Security;

require_once __DIR__ . '/data/testConst.php';
require_once __DIR__ . '/data/testSettings.php';
require_once __DIR__ . '/Security.php';

echo '[WARNING] This script should NOT be distributed or uploaded to a Vault server.'.PHP_EOL;
echo '[WARNING] It is a test script designed to identify if there are issues with the Vault codebase.'.PHP_EOL;
echo PHP_EOL;
echo 'Beginning Vault tests.'.PHP_EOL;

$pass = 0;

$security = new Security();
$pass += $security->run();

echo PHP_EOL;
echo $pass.'/13 tests passed.';
echo PHP_EOL;
