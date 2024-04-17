<?php
use Vault\data\DataManager;

if (isset($_GET['delete'])) {
    $dm = new DataManager();
    $dm->deleteUser($_GET['delete']);
    $dm->deleteVault($_GET['delete']);
}
?><!DOCTYPE html>
<html lang="en" xmlns:x-on="http://www.w3.org/1999/xhtml">
    <head>
        <title>Vault Users</title>
        <?php require_once __DIR__.'/common/head.php'; ?>
    </head>
    <body class="flex w-screen min-h-screen h-full">
        <?php require_once __DIR__.'/common/sidebar.php'; ?>

        <div class="flex-grow">
            <?php require_once __DIR__.'/common/alerts.php';?>

            <header>
                <h1>Users</h1>
            </header>

            <?php require_once __DIR__.'/common/nav.php';?>

            <?php if ($_SESSION['role'] == 1) { ?>
            <main class="grid grid-cols-4 gap-4">
                <?php
                    $userData = file_get_contents(__DIR__ . '/../' . USERS_FILE);
                    $jsonData = json_decode($userData);
                    foreach ($jsonData as $User) {
                ?>
                <div class="bg-neutral-100 p-2 flex">
                    <div class="flex-grow">
                        <strong><?= $User->user; ?></strong><br>
                        <?php
                            if ($User->role === '1') { ?>Administrator<?php }
                            elseif ($User->role === '0') { ?>User<?php }
                        ?>
                    </div>
                    <?php if ($User->user !== $_SESSION['user']) { ?>
                    <button
                        onclick="window.location = '/users?delete=<?= $User->user; ?>'"
                        class="btn-red text-white"
                    >
                        <i class="fa-solid fa-trash-can"></i> Delete
                    </button>
                    <?php } ?>
                </div>
                <?php } ?>
            </main>
            <?php } else {
                header('Location: / ');
                exit;
            } ?>
        </div>
    </body>
</html>
