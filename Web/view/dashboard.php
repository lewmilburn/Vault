<?php
    use Vault\security\InputManager;
    $im = new InputManager();
?><!DOCTYPE html>
<html lang="en" xmlns:x-on="http://www.w3.org/1999/xhtml">
    <head>
        <title>Vault</title>
        <?php require_once __DIR__.'/common/head.php'; ?>
    </head>
    <body class="flex w-screen h-screen">
        <?php require_once __DIR__.'/common/sidebar.php'; ?>
        <div class="flex-grow">
            <?php require_once __DIR__.'/common/alerts.php';?>

            <header>
                <h1>Dashboard</h1>
            </header>

            <?php require_once __DIR__.'/common/nav.php';?>

            <main>
                <div class="alert-red mb-6 hidden" id="error"></div>
                <div class="alert-green mb-6 hidden" id="success"></div>
                <div class="grid-std" x-data="{
                    open:false,
                    newItem: false,
                    pid: '',
                    pass: '',
                    user: '',
                    name: '',
                    url: '',
                    notes: '',
                    strength: ''
                }">
                    <div class="grid" id="passwordGrid">
                    </div>
                    <div class="border p-2" x-show="open">
                        <h2 class="text-center" x-show="!newItem" x-text="name"></h2>
                        <h2 class="text-center" x-show="newItem">Add a new password</h2>
                        <div class="grid-std">
                            <div class="hidden" aria-hidden="true">
                                <label for="pid" class="h3 text-center w-full" aria-hidden="true">PID</label><br>
                                <input type="text" id="pid" name="pid" x-model="pid" class="w-full" aria-hidden="true">
                            </div>
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
                            <div>
                                <p class="h3 w-full">Password Strength: <span x-text="strength"></span>/10</p>
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
                                    strength='';
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
                                    value="update"
                                    :id="pid"
                                >
                                    Save changes
                                </button>
                                <button
                                    type="submit"
                                    x-show="!newItem"
                                    class="btn-red"
                                    name="type"
                                    value="delete"
                                    :id="pid"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script>
            localStorage.setItem('user', '<?= $_SESSION['user']; ?>');
            localStorage.setItem('key', '<?= urlencode($_SESSION['key']); ?>');

            function getVault () {
                $.ajax({
                    url: '/api/vault/?user='+localStorage.getItem('user')+'&key='+localStorage.getItem('key'),
                    type: 'GET',
                    success: function (data) {
                        displayPasswords(data.data);
                    },
                    error: function (xhr) {
                        displayError('Unable to retrieve passwords', xhr.responseText);
                    }
                });
            }

        </script>
        <script defer src="/assets/js/lib/alpine.js"></script>
        <script src="/assets/js/lib/jquery.js"></script>
        <script src="/assets/js/api.js"></script>
        <script src="/assets/js/dashboard.js"></script>
        <script src="/assets/js/strength.js"></script>
    </body>
</html>
