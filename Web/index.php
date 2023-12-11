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

    $router->getRequest('/api/vault', 'api/vault/get.php');
    $router->putRequest('/api/vault', 'api/vault/update.php');
    $router->postRequest('/api/vault', 'api/vault/create.php');
    $router->deleteRequest('/api/vault', 'api/vault/delete.php');

    $router->getRequest('/api/strength', 'api/strength.php');
} else {
    $router->getRequest('', 'view/login.php');
    $router->postRequest('/auth', 'event/login.php');

    $router->anyRequest('/api/vault', 'event/unauthorised.php');
    $router->getRequest('/api/strength', 'event/unauthorised.php');
}
$router->anyRequest('/api/status', 'api/status.php');

$router->endRouter();
