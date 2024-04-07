<?php
use Vault\Libraries\PHPGangsta_GoogleAuthenticator;
use Vault\security\ValidationManager;
$factor = new PHPGangsta_GoogleAuthenticator();
$secret = $factor->createSecret();
$qr = $factor->getQRCodeGoogleUrl($_SERVER['SERVER_NAME'], $secret, 'Vault');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Create an Account - Vault</title>
        <?php require_once __DIR__.'/common/head.php'; ?>
    </head>
    <body class="flex w-screen h-screen">
        <nav class="flex flex-col bg-blue-700 p-0">
            <span class="flex-grow"></span>
            <i class="fa-solid fa-lock btn-sidebar" title="Secured with AEAD Encryption"></i>
        </nav>
        <div class="flex-grow">
            <?php require_once __DIR__.'/common/alerts.php'; ?>

            <?php if (isset($_GET['rf'])) { ?>
                <?php if (isset($_GET['rf']) && $_GET['rf'] == 'userExists') { ?>
                    <div class="alert-red">
                        Setup failed, a user with this account name already exists.
                    </div>
                <?php } ?>
                <?php if (isset($_GET['rf']) && $_GET['rf'] == 'pass') { ?>
                    <div class="alert-red">
                        Your password must contain 8 characters,
                        including at least 1 uppercase,
                        1 lowercase, 1 number, and 1 symbol.
                    </div>
                <?php } ?>
                <?php if (isset($_GET['rf']) && $_GET['rf'] == 'user') { ?>
                    <div class="alert-red">
                        Your username must be at least 4 characters
                        and can not include any symbols.
                    </div>
                <?php } ?>
                <?php if (isset($_GET['rf']) && $_GET['rf'] == 'user') { ?>
                    <div class="alert-red">
                        Invalid two-factor authentication code.
                    </div>
                <?php } ?>
            <?php } ?>

            <header class="mb-6">
                <h1>Create an Account.</h1>
            </header>

            <main>
                <form action="/reg" method="post" class="text-center sm:w-1/2 md:w-1/3 lg:w-1/4 mx-auto">
                    <div class="hidden">
                        <input id="secret" name="secret" value="<?= $secret; ?>">
                    </div>
                    <input
                        id="csrf"
                        name="csrf"
                        class="hidden"
                        value="<?php $vm = new ValidationManager(); echo $vm->csrfToken(); ?>"
                        aria-hidden="true"
                    >
                    <div class="grid">
                        <label for="user">Username</label>
                        <input id="user" name="user">
                    </div>
                    <div class="grid">
                        <label for="pass">Password</label>
                        <input id="pass" name="pass" type="password">
                    </div>
                    <div class="grid">
                        <label for="code">Two-factor Authentication QR Setup</label>
                        <img src="<?= $qr; ?>" class="mx-auto" alt="Two-factor Authentication QR Setup">
                    </div>
                    <div class="grid">
                        <label for="code">2FA Code</label>
                        <input id="code" name="code" type="password">
                    </div>
                    <div class="grid">
                        <button type="submit" class="btn-primary">Register</button>
                        <a href="/">Login</a>
                    </div>
                </form>
            </main>
        </div>
    </body>
</html>
