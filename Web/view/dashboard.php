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
            <div class="grid-std" x-data="{
                open:false,
                newItem: false,
                pass: '',
                user: '',
                name: '',
                url: '',
                notes: ''
            }">
                <div class="grid">
                    <div class="grid-item-password" x-on:click="
                        open=true;
                        newItem=true;
                        pass='';
                        user='';
                        name='';
                        url='';
                        notes='';
                    ">
                        Add a new password
                    </div>
                    <?php
                        $dm = new \Vault\data\DataManager();
                        $vault = $dm->getVault($_SESSION['user'], $_SESSION['key']);
                        foreach ($vault as $password) { if (isset($password->name)) { ?>
                    <div class="grid-item-password" x-on:click="
                        open=true;
                        newItem=false;
                        pass='<?= $password->pass; ?>';
                        user='<?= $password->user; ?>';
                        name='<?= $password->name; ?>';
                        url='<?= $password->url; ?>';
                        notes='<?= $password->notes; ?>';
                    ">
                        <?= $password->name; ?>
                    </div>
                    <?php
                        }
                        }
                    ?>
                </div>
                <div class="border p-2" x-show="open">
                    <h2 class="text-center" x-show="!newItem" x-text="name"></h2>
                    <h2 class="text-center" x-show="newItem">Add a new password</h2>
                    <form class="grid-std" action="/api/password/create" method="post">
                        <div>
                            <label for="user" class="h3 text-center w-full">Username</label><br>
                            <input type="text" id="user" name="user" x-model="user" class="w-full">
                        </div>
                        <div>
                            <label for="pass" class="h3 text-center w-full">Password</label><br>
                            <input type="text" id="pass" name="pass" x-model="pass" class="w-full">
                        </div>
                        <div>
                            <label for="name" class="h3 text-center w-full">Website name</label><br>
                            <input type="text" id="name" name="name" x-model="name" class="w-full">
                        </div>
                        <div>
                            <label for="url" class="h3 text-center w-full">URL</label><br>
                            <input type="text" id="url" name="url" x-model="url" class="w-full">
                        </div>
                        <div class="col-span-2">
                            <label for="notes" class="h3 text-center w-full">Notes</label><br>
                            <textarea type="text" id="notes" name="notes" x-text="notes" class="w-full"></textarea>
                        </div>
                        <div class="col-span-2 flex space-x-2">
                            <button type="button" class="inline btn-primary" x-on:click="
                                open=false;
                                newItem=false;
                                pass='';
                                user='';
                                name='';
                                url='';
                                notes='';
                            ">Close</button>
                            <button
                                type="submit"
                                x-show="newItem"
                                class="btn-green flex-grow"
                                name="type"
                                value="create"
                            >
                                Add to Vault
                            </button>
                            <button
                                type="submit"
                                x-show="!newItem"
                                class="btn-green flex-grow"
                                name="type"
                                value="save"
                            >
                                Save changes
                            </button>
                            <button
                                type="submit"
                                x-show="!newItem"
                                class="btn-red"
                                name="type"
                                value="delete"
                            >
                                Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>
