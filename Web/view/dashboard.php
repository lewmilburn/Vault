<?php
    use Vault\security\InputManager;
    $im = new InputManager();
?><!DOCTYPE html>
<html lang="en" xmlns:x-on="http://www.w3.org/1999/xhtml">
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
            <div class="grid-std" x-data="{ open:false, newItem: false, pass: '', user: '', url: '', notes: '' }">
                <div class="grid">
                    <div class="grid-item-password" x-on:click="open=true;newItem=true;">
                        Add a new password
                    </div>
                    <?php
                        $dm = new \Vault\data\DataManager();
                        $vault = $dm->getVault($_SESSION['user'], $_SESSION['key']);
                        foreach ($vault as $password) { ?>
                    <div class="grid-item-password" x-on:click="open=true;newItem=false;pass='<?= $password->pass; ?>';user='<?= $password->user; ?>';url='<?= $password->url; ?>';notes='<?= $password->notes; ?>'">
                        <?= $password->name; ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="border p-2" x-show="open">
                    <h2 class="text-center"><?= $password->name; ?></h2>
                    <form class="grid-std">
                        <div>
                            <label for="user" class="h3 text-center w-full">Username</label><br>
                            <input type="text" id="user" x-model="user" class="w-full">
                        </div>
                        <div>
                            <label for="pass" class="h3 text-center w-full">Password</label><br>
                            <input type="text" id="pass" x-model="pass" class="w-full">
                        </div>
                        <div class="col-span-2">
                            <label for="url" class="h3 text-center w-full">URL</label><br>
                            <input type="text" id="url" x-model="url" class="w-full">
                        </div>
                        <div class="col-span-2">
                            <label for="notes" class="h3 text-center w-full">Notes</label><br>
                            <textarea type="text" id="notes" x-text="notes" class="w-full"></textarea>
                        </div>
                        <button type="submit" x-show="newItem" class="btn-primary col-span-2">Add to Vault</button>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>
