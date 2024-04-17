<?php
use Vault\security\ValidationManager;
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login to Vault</title>
        <?php require_once __DIR__.'/common/head.php'; ?>
    </head>
    <body class="flex w-screen h-screen">
        <nav class="flex flex-col bg-blue-700 p-0">
            <span class="flex-grow"></span>
            <i
                class="fa-regular fa-circle-question btn-sidebar"
                onclick="window.open('https://github.com/lewmilburn/Vault/wiki/Vault-User-Guide', '_blank').focus();"
                title="View Help"
            ></i>
            <i class="fa-solid fa-lock btn-sidebar" title="Secured with AEAD Encryption"></i>
        </nav>
        <div class="flex-grow">
            <?php require_once __DIR__.'/common/alerts.php'; ?>

            <?php if (isset($_GET['lf'])) { ?>
                <?php if ($_GET['lf'] == 'csrf') { ?>
                    <div class="alert-red">
                        A possible cross-site request forgery attempt was detected and this login was aborted.
                    </div>
                <?php } ?>
                <?php if ($_GET['lf'] == 'none') { ?>
                    <div class="alert-red">
                        Please enter a username and password.
                    </div>
                <?php } ?>
                <?php if ($_GET['lf'] == 'wrong') { ?>
                    <div class="alert-red">
                        Incorrect username or password.
                    </div>
                <?php } ?>
                <?php if ($_GET['lf'] == 'code') { ?>
                    <div class="alert-red">
                        Incorrect two-factor authentication code.
                    </div>
                <?php } ?>
            <?php } ?>

            <header class="mb-6">
                <h1>Login to Vault.</h1>
            </header>

            <main>
                <form action="/auth" method="post" class="text-center sm:w-1/2 md:w-1/3 lg:w-1/4 mx-auto">
                    <label for="csrf" class="hidden">Hidden field</label>
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
                        <label for="code">Two Factor Authentication Code</label>
                        <input id="code" name="code" type="password">
                    </div>
                    <div class="grid">
                        <button type="submit" class="btn-primary">Login</button>
                        <?php if (ALLOW_REGISTRATION) { ?><a href="/register">Register</a><?php } ?>
                    </div>
                </form>
            </main>
        </div>
    </body>
</html>
