<?php

/**
 * @author Lewis Milburn
 * @license Apache 2.0 International License
 */

use Vault\event\routeHandler;

ob_start();
session_start();

require_once __DIR__.'/loader.php';

$router = new routeHandler();
$router->getRequest('/', 'view/login.php');

$router->endRouter();

ob_end_flush();
