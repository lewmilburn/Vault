<?php

session_start();

use Vault\test\Authentication;
use Vault\test\Event;
use Vault\test\Security;
use Vault\test\Data;

require_once __DIR__.'/data/testConst.php';
require_once __DIR__.'/data/testSettings.php';

require_once __DIR__.'/Security.php';
require_once __DIR__.'/Authentication.php';
require_once __DIR__.'/Data.php';
require_once __DIR__.'/Event.php';

echo '[WARNING] This script should NOT be distributed or uploaded to a Vault server.'.PHP_EOL;
echo '[WARNING] It is a test script designed to identify if there are issues with the Vault codebase.'.PHP_EOL;
echo PHP_EOL;
echo 'Beginning Vault tests.'.PHP_EOL;

$pass = 0;

$security = new Security();
$pass += $security->run();

echo PHP_EOL;

$authentication = new Authentication();
$pass += $authentication->run();

echo PHP_EOL;

$data = new Data();
$pass += $data->run();

echo PHP_EOL;

$event = new Event();
$pass += $event->run();

echo PHP_EOL;
echo $pass.'/20 tests passed.';
echo PHP_EOL;
