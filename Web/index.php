<?php

/**
 * @author Lewis Milburn
 * @license Apache 2.0 International License
 */

use Vault\authentication\tokenManager;
use Vault\event\routeHandler;

ob_start();
session_start();

require_once __DIR__.'/loader.php';

$router = new routeHandler();
$token = new tokenManager();

if ($token->validToken($_SESSION['token'],$_SESSION['user'])) {
    $router->getRequest('/', 'view/dashboard.php');
} else {
    $router->getRequest('/', 'view/login.php');
    $router->postRequest('/auth', 'event/login.php');
}

$router->endRouter();

ob_end_flush();
