<?php
use Vault\InputManager;
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vault</title>
        <?php require_once __DIR__.'/common/head.php'; ?>
    </head>
    <body>
        <?php require_once __DIR__.'/common/alerts.php'; ?>

        <?php if (isset($_GET['temp'])) { $im = new InputManager();?>
            <div class="alert-red">
                A temporary account has been set up.
                Username = 'admin'
                Password = '<?= $im->escapeString($_GET['temp']); ?>'
            </div>
        <?php } ?>

        <header>
            <h1>Login to Vault.</h1>
        </header>

        <main>
            <form action="/auth" method="post" class="text-center sm:w-1/2 md:w-1/3 lg:w-1/4 mx-auto">
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
