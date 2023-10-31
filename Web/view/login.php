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

        <h1 class="text-center">Login to Vault.</h1>

        <form action="/auth" method="post">
            <label for="user">Username</label>
            <input id="user" name="user">
            <br>
            <label for="pass">Password</label>
            <input id="pass" name="pass" type="password">
            <br>
            <button type="submit">Login</button>
        </form>
    </body>
</html>
