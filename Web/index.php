<?php

/**
 * @author Lewis Milburn
 * @license Apache 2.0 International License
 */

use Vault\authentication\authenticationManager;
use Vault\event\routeHandler;

ob_start();
session_start();

require_once __DIR__.'/loader.php';

$router = new routeHandler();
$auth = new authenticationManager();

if ($auth->authenticated()) {
    $router->getRequest('/', 'view/dashboard.php');
} else {
    $router->getRequest('/', 'view/login.php');
    $router->postRequest('/auth', 'event/login.php');
}

$router->endRouter();

ob_end_flush();
