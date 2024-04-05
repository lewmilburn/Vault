<!DOCTYPE html>
<html lang="en" xmlns:x-on="http://www.w3.org/1999/xhtml">
    <head>
        <title>Vault Users</title>
        <?php require_once __DIR__.'/common/head.php'; ?>
    </head>
    <body class="flex w-screen h-screen">
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
                <div class="bg-neutral-100 p-2">
                    <strong><?= $User->user; ?></strong><br>
                    <?php
                        if ($User->role === '1') { ?>Administrator<?php }
                        elseif ($User->role === '0') { ?>User<?php }
                    ?>
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
