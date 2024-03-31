<?php

session_start();

use Vault\test\Authentication;
use Vault\test\Security;

require_once __DIR__.'/../data/const.php';
require_once __DIR__.'/../settings.php';

require_once __DIR__.'/Security.php';
require_once __DIR__.'/Authentication.php';

echo '[WARNING] This script should NOT be distributed or uploaded to a Vault server.'.PHP_EOL;
echo '[WARNING] It is a test script designed to identify if there are issues with the Vault codebase.'.PHP_EOL;
echo '[WARNING] Enter "Y" to continue.'.PHP_EOL;

$handle = fopen ("php://stdin","r");
$line = fgets($handle);
if(strtoupper(trim($line)) != 'Y'){
    echo PHP_EOL;
    echo "Cancelled testing.\n";
    fclose($handle);
    exit;
}

fclose($handle);

echo PHP_EOL;
echo 'Beginning Vault tests.'.PHP_EOL.PHP_EOL;

$pass = 0;

$security = new Security();
$pass += $security->run();

echo PHP_EOL;

$authentication = new Authentication();
$pass += $authentication->run();

echo PHP_EOL;

echo PHP_EOL;
echo $pass.'/18 tests passed.';
echo PHP_EOL;
