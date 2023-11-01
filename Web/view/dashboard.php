<?php
    use Vault\security\InputManager;
    $im = new InputManager();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vault</title>
        <?php require_once __DIR__.'/common/head.php'; ?>
    </head>
    <body>
        <?php require_once __DIR__.'/common/alerts.php'; ?>

        <header>
            <h1>Dashboard</h1>
        </header>

        <main>
            <p>Welcome back, <?= $im->escapeString($_SESSION['user']); ?></p>
            <a class="btn-primary" href="/logout">Log out</a>
        </main>
    </body>
</html>
