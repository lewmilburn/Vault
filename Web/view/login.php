<?php
use Vault\security\InputManager;
use Vault\security\ValidationManager;
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vault</title>
        <?php require_once __DIR__.'/common/head.php'; ?>
    </head>
    <body>
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
        <?php } ?>

        <header class="mb-6">
            <h1>Login to Vault.</h1>
        </header>

        <main>
            <form action="/auth" method="post" class="text-center sm:w-1/2 md:w-1/3 lg:w-1/4 mx-auto">
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
                <button type="submit" class="btn-primary">Login</button>
            </form>
        </main>
    </body>
</html>
