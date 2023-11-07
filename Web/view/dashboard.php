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
        <?php require_once __DIR__.'/common/alerts.php';?>

        <header>
            <h1>Dashboard</h1>
        </header>

        <?php require_once __DIR__.'/common/nav.php';?>

        <main>
            <div class="grid-cols-2">
                <?php
                    $dm = new \Vault\data\DataManager();
                    $dm->getVault($_SESSION['user'], $_SESSION['key']);
                ?>
            </div>
        </main>
    </body>
</html>
