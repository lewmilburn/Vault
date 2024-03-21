<?php
    use Vault\security\InputManager;
    $im = new InputManager();

    if ($_SESSION['role'] !== 1) {
        header('Location: /');
        exit;
    }
?><!DOCTYPE html>
<html lang="en" xmlns:x-on="http://www.w3.org/1999/xhtml">
    <head>
        <title>Vault Settings</title>
        <?php require_once __DIR__.'/common/head.php'; ?>
    </head>
    <body>
        <?php require_once __DIR__.'/common/alerts.php';?>

        <header>
            <h1>Settings</h1>
        </header>

        <?php require_once __DIR__.'/common/nav.php';?>

        <main class="grid gap-4">
            <div class="alert-red mb-6 hidden" id="error"></div>
            <div class="alert-green mb-6 hidden" id="success"></div>
            <div class="grid gap-2">
                <h2>Global Settings</h2>
                <div class="grid">
                    <label for="ENV">Environment</label>
                    <select id="ENV" class="w-full">
                        <option value="DEV"<?php if (ENV==DEV) { ?> selected<?php } ?>>Development</option>
                        <option value="PROD"<?php if (ENV==PROD) { ?> selected<?php } ?>>Production</option>
                    </select>
                </div>

                <div class="grid">
                    <label for="STORAGE_TYPE">Storage Type</label>
                    <select id="STORAGE_TYPE" class="w-full">
                        <option value="FILESYSTEM"<?php if (STORAGE_TYPE==FILESYSTEM) { ?> selected<?php } ?>>Filesystem</option>
                        <option value="DATABASE"<?php if (STORAGE_TYPE==DATABASE) { ?> selected<?php } ?>>Database</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="grid gap-2">
                <h2>Filesystem Storage Settings</h2>
                <div class="grid">
                    <label for="USERS_FILE">Users File</label>
                    <input id="USERS_FILE" value="<?= USERS_FILE; ?>" class="w-full">
                </div>

                <div class="grid">
                    <label for="SECURE_LOCATION">Secure Location</label>
                    <input id="SECURE_LOCATION" value="<?= SECURE_LOCATION; ?>" class="w-full">
                </div>

                <div class="grid">
                    <label for="FILE_SEPARATOR">File Separator</label>
                    <input id="FILE_SEPARATOR" value="<?= FILE_SEPARATOR; ?>" class="w-full">
                </div>

                <div class="grid">
                    <label for="DEFAULT_HASH">Default Hash</label>
                    <input id="DEFAULT_HASH" value="<?= DEFAULT_HASH; ?>" class="w-full">
                </div>

                <div class="grid">
                    <label for="USER_HASH">User Hash</label>
                    <input id="USER_HASH" value="<?= USER_HASH; ?>" class="w-full">
                </div>

                <div class="grid">
                    <label for="CHECKSUM_HASH">Checksum Hash</label>
                    <input id="CHECKSUM_HASH" value="<?= CHECKSUM_HASH; ?>" class="w-full">
                </div>
            </div>
            <br>
            <div class="grid gap-2">
                <h2>Database Storage Settings</h2>
                <div class="grid">
                    <label for="DB_HOST">Database Host</label>
                    <input id="DB_HOST" value="<?= DB_HOST; ?>" class="w-full">
                </div>

                <div class="grid">
                    <label for="DB_NAME">Database Name</label>
                    <input id="DB_NAME" value="<?= DB_NAME; ?>" class="w-full">
                </div>

                <div class="grid">
                    <label for="DB_USER">Database User</label>
                    <input id="DB_USER" value="<?= DB_USER; ?>" class="w-full">
                </div>

                <div class="grid">
                    <label for="DB_PASS">Database Password</label>
                    <input id="DB_PASS" value="<?= DB_PASS; ?>" class="w-full">
                </div>

                <div class="grid">
                    <label for="DB_PORT">Database Port</label>
                    <input id="DB_PORT" value="<?= DB_PORT; ?>" class="w-full">
                </div>

                <div class="grid">
                    <label for="DB_SOCKET">Database Socket</label>
                    <input id="DB_SOCKET" value="<?= DB_SOCKET; ?>" class="w-full">
                </div>

                <div class="grid">
                    <label for="DB_PREFIX">Database Prefix</label>
                    <input id="DB_PREFIX" value="<?= DB_PREFIX; ?>" class="w-full">
                </div>
            </div>
        </main>
    </body>
</html>
