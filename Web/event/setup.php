<?php

use Vault\data\DataManager;
use Vault\data\FileManager;
use Vault\security\InputManager;
use Vault\security\ValidationManager;

$setup = true;
require_once __DIR__ . '/../autoload.php';

if (isset($_POST['user']) && isset($_POST['pass'])) {

    $im = new InputManager();
    $user = $im->escapeString($_POST['user']);
    $pass = $im->escapeString($_POST['pass']);

    $user = trim($user);
    $pass = trim($pass);

    $vm = new ValidationManager();
    if (!$vm->validatePasswordStrength($pass)) {
        header('Location: /?sf=pass');
        exit;
    }

    if (!$vm->validateUsername($user)) {
        header('Location: /?sf=user');
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
        <?php } if (isset($_GET['sf']) && $_GET['sf'] == 'user') { ?>
            <div class="alert-red">
                Your username must be at least 4 characters and can not include any symbols.
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

