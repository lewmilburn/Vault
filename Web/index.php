<?php

/**
 * @author Lewis Milburn
 * @license Apache 2.0 International License
 */

use Vault\authentication\AuthenticationManager;
use Vault\event\RouteHandler;

ob_start();
session_start();

require_once __DIR__.'/autoload.php';

$router = new RouteHandler();
$auth = new AuthenticationManager();

if ($auth->authenticated()) {
    $router->getRequest('', 'view/dashboard.php');
    $router->getRequest('/logout', 'event/logout.php');

    $router->postRequest('/api/password', 'api/password/router.php');

    $router->getRequest('/api/vault', 'api/vault/get.php');
    $router->putRequest('/api/vault', 'api/vault/put.php');
} else {
    $router->getRequest('', 'view/login.php');
    $router->postRequest('/auth', 'event/login.php');

    $router->postRequest('/api/password', 'event/unauthorised.php');
}

$router->endRouter();

ob_end_flush();
