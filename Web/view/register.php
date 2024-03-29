<?php
use Vault\security\InputManager;
use Vault\security\ValidationManager;
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vault</title>
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
                <?php if ($_GET['rf'] == 'csrf') { ?>
                    <div class="alert-red">
                        A possible cross-site request forgery attempt was detected and this login was aborted.
                    </div>
                <?php } ?>
                <?php if ($_GET['rf'] == 'none') { ?>
                    <div class="alert-red">
                        Please enter a username and password.
                    </div>
                <?php } ?>
                <?php if ($_GET['rf'] == 'wrong') { ?>
                    <div class="alert-red">
                        Incorrect username or password.
                    </div>
                <?php } ?>
            <?php } ?>

            <header class="mb-6">
                <h1>Login to Vault.</h1>
            </header>

            <main>
                <form action="/reg" method="post" class="text-center sm:w-1/2 md:w-1/3 lg:w-1/4 mx-auto">
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
                        <button type="submit" class="btn-primary">Register</button>
                        <a href="/">Login</a>
                    </div>
                </form>
            </main>
        </div>
    </body>
</html>
