<?php

use Vault\data\DataManager;use Vault\data\FileManager;use Vault\security\InputManager;

require_once __DIR__ . '/../data/const.php';
require_once __DIR__ . '/../Settings.php';
require_once __DIR__ . '/../security/InputManager.php';
require_once __DIR__ . '/../security/HashManager.php';
require_once __DIR__ . '/../security/EncryptionManager.php';
require_once __DIR__ . '/../data/DataManager.php';
require_once __DIR__ . '/../data/FileManager.php';
require_once __DIR__ . '/../data/DatabaseManager.php';

if (isset($_POST['user']) && isset($_POST['pass'])) {

    $im = new InputManager();
    $user = $im->escapeString($_POST['user']);
    $pass = $im->escapeString($_POST['pass']);

    $user = trim($user);
    $pass = trim($pass);

    if (!$im->validatePasswordStrength($pass)) {
        header('Location: /?sf=pass');
        exit;
    }

    $dm = new DataManager();
    if (!$dm->createUser($user,$pass)) {
        header('Location: /?sf=userExists');
        exit;
    }

    $dm->createVault($user, $pass);

    $fm = new FileManager();
    file_put_contents(__DIR__ . '/../run.json', '{"config":true}');

    header('Location: /?sc');
} else { ?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vault</title>
        <?php require_once __DIR__.'/../view/common/head.php'; ?>
    </head>
    <body>
        <?php require_once __DIR__.'/../view/common/alerts.php'; ?>

        <?php if (isset($_GET['sf']) && $_GET['sf'] == 'userExists') { ?>
            <div class="alert-red">
                Setup failed, a user with this account name already exists.
            </div>
        <?php } if (isset($_GET['sf']) && $_GET['sf'] == 'pass') { ?>
            <div class="alert-red">
                Your password must contain 8 characters, including at least 1 uppercase, 1 lowercase, 1 number, and 1 symbol.
            </div>
        <?php } ?>

        <header>
            <h1>Welcome to Vault.</h1>
            <p>Please create an account.</p>
        </header>

        <main>
            <form action="/" method="post" class="text-center sm:w-1/2 md:w-1/3 lg:w-1/4 mx-auto">
                <div class="grid">
                    <label for="user">Username</label>
                    <input id="user" name="user">
                </div>
                <div class="grid">
                    <label for="pass">Password</label>
                    <input id="pass" name="pass" type="password">
                </div>
                <button type="submit" class="btn-primary">Login</button>
            </form>
        </main>
    </body>
</html>
<?php } ?>

