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

// Web client only
if ($auth->authenticated()) {
    $router->getRequest('', 'view/dashboard.php');
    $router->getRequest('/users', 'view/users.php');
    $router->getRequest('/settings', 'view/settings.php');
    $router->postRequest('/settings', 'view/settings.php');
} else {
    $router->getRequest('', 'view/login.php');
    if (ALLOW_REGISTRATION) {
        $router->getRequest('/register', 'view/register.php');
        $router->postRequest('/reg', 'event/register.php');
    }
    $router->postRequest('/auth', 'event/login.php');

    $router->anyRequest('/api/auth/login', 'api/authentication/login.php');
}
$router->getRequest('/logout', 'event/logout.php');

$router->putRequest('/api/password', 'api/password/update.php');
$router->deleteRequest('/api/password', 'api/password/delete.php');
$router->postRequest('/api/password', 'api/password/create.php');

$router->getRequest('/api/vault', 'api/vault/get.php');
$router->getRequest('/api/user/resync', 'api/user/resync.php');

$router->anyRequest('/api/status', 'api/status.php');
$router->getRequest('/api/strength', 'api/strength.php');

$router->endRouter();
