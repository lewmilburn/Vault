<?php
use Vault\security\InputManager;
use Vault\data\SettingsManager;

$error = null;

function updateSettings(): string|null
{
    $sm = new SettingsManager();

    return $sm->updateFromPost();
}

if (isset($_POST['submit'])) {
    $error = updateSettings();
    if ($error === null) {
        header('Location: /settings?saved');
        exit;
    }
}
?><!DOCTYPE html>
<html lang="en" xmlns:x-on="http://www.w3.org/1999/xhtml">
    <head>
        <title>Vault Settings</title>
        <?php require_once __DIR__.'/common/head.php'; ?>
    </head>
    <body class="flex w-screen h-screen">
        <?php require_once __DIR__.'/common/sidebar.php'; ?>

        <div class="flex-grow">
            <?php require_once __DIR__.'/common/alerts.php';?>

            <header>
                <h1>Settings</h1>
            </header>

            <?php require_once __DIR__.'/common/nav.php';?>

            <main class="grid gap-4">
                <?php if ($error !== null) { ?>
                    <div class="alert-red mb-6"><?= $error; ?></div>
                <?php } elseif (isset($_GET['saved'])) { ?>
                    <div class="alert-green mb-6">Your changes have been saved.</div>
                <?php } ?>
                <?php if ($_SESSION['role'] == 1) { ?>
                <form class="grid gap-4" action="" method="post">
                    <div class="grid gap-2">
                        <h2>Global Settings</h2>
                        <div class="grid">
                            <label for="ENV">Environment</label>
                            <select id="ENV" name="ENV" class="w-full">
                                <option value="DEV"<?php if (ENV==DEV) { ?> selected<?php } ?>>
                                    Development
                                </option>
                                <option value="PROD"<?php if (ENV==PROD) { ?> selected<?php } ?>>
                                    Production (Recommended)
                                </option>
                            </select>
                        </div>

                        <div class="grid">
                            <label for="STORAGE_TYPE">Storage Type</label>
                            <div class="alert-yellow">
                                Changing this setting may result in user data being lost.
                            </div>
                            <select id="STORAGE_TYPE" name="STORAGE_TYPE" class="w-full">
                                <option
                                    value="FILESYSTEM"<?php if (STORAGE_TYPE==FILESYSTEM) { ?> selected<?php } ?>
                                >
                                    Filesystem
                                </option>
                                <option
                                    value="DATABASE"<?php if (STORAGE_TYPE==DATABASE) { ?> selected<?php } ?>
                                >
                                    Database
                                </option>
                            </select>
                        </div>

                        <div class="grid">
                            <label for="ALLOW_REGISTRATION">Allow Registration</label>
                            <select id="ALLOW_REGISTRATION" name="ALLOW_REGISTRATION" class="w-full">
                                <option
                                        value="true"<?php if (ALLOW_REGISTRATION) { ?> selected<?php } ?>
                                >
                                    Yes
                                </option>
                                <option
                                        value="DATABASE"<?php if (!ALLOW_REGISTRATION) { ?> selected<?php } ?>
                                >
                                    No
                                </option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="grid gap-2">
                        <h2>Filesystem Storage Settings</h2>
                        <div class="alert-yellow">
                            Changing these settings may result in user data being lost.
                        </div>
                        <div class="grid">
                            <label for="USERS_FILE">Users File</label>
                            <input id="USERS_FILE" name="USERS_FILE" value="<?= USERS_FILE; ?>" class="w-full">
                        </div>

                        <div class="grid">
                            <label for="SECURE_LOCATION">Secure Location</label>
                            <input
                                id="SECURE_LOCATION"
                                name="SECURE_LOCATION"
                                value="<?= SECURE_LOCATION; ?>"
                                class="w-full"
                            >
                        </div>

                        <div class="grid">
                            <label for="FILE_SEPARATOR">File Separator</label>
                            <input
                                id="FILE_SEPARATOR"
                                name="FILE_SEPARATOR"
                                value="<?= FILE_SEPARATOR; ?>"
                                class="w-full"
                            >
                        </div>

                        <div class="grid">
                            <label for="DEFAULT_HASH">Default Hash</label>
                            <select id="DEFAULT_HASH" name="DEFAULT_HASH" class="w-full">
                                <option value="sha3-512"<?php if (DEFAULT_HASH=='sha3-512') { ?> selected<?php } ?>>
                                    sha3-512 (Recommended)
                                </option>
                                <option value="sha3-384"<?php if (DEFAULT_HASH=='sha3-384') { ?> selected<?php } ?>>
                                    sha3-384
                                </option>
                                <option value="sha3-256"<?php if (DEFAULT_HASH=='sha3-256') { ?> selected<?php } ?>>
                                    sha3-256
                                </option>
                                <option value="sha3-224"<?php if (DEFAULT_HASH=='sha3-224') { ?> selected<?php } ?>>
                                    sha3-224
                                </option>
                                <option value="whirlpool"<?php if (DEFAULT_HASH=='whirlpool') { ?> selected<?php } ?>>
                                    whirlpool
                                </option>
                                <option value="gost-crypto"<?php if(DEFAULT_HASH=='gost-crypto'){ ?> selected<?php } ?>>
                                    gost-crypto
                                </option>
                            </select>
                        </div>

                        <div class="grid">
                            <label for="USER_HASH">User ID Generating Hash</label>
                            <select id="USER_HASH" name="USER_HASH" class="w-full">
                                <option value="crc32"<?php if (USER_HASH=='crc32') { ?> selected<?php } ?>>
                                    crc32 (Recommended)
                                </option>
                                <option value="crc32b"<?php if (USER_HASH=='crc32b') { ?> selected<?php } ?>>
                                    crc32b
                                </option>
                                <option value="crc32c"<?php if (USER_HASH=='crc32c') { ?> selected<?php } ?>>
                                    crc32c
                                </option>
                                <option value="adler32"<?php if (USER_HASH=='adler32') { ?> selected<?php } ?>>
                                    adler32
                                </option>
                            </select>
                        </div>

                        <div class="grid">
                            <label for="CHECKSUM_HASH">Checksum Hash</label>
                            <select id="CHECKSUM_HASH" name="CHECKSUM_HASH" class="w-full">
                                <option value="sha1"<?php if (CHECKSUM_HASH=='sha1') { ?> selected<?php } ?>>
                                    sha1 (Recommended)
                                </option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="grid gap-2">
                        <h2>Database Storage Settings</h2>
                        <div class="grid">
                            <label for="DB_HOST">Database Host</label>
                            <input id="DB_HOST" name="DB_HOST" value="<?= DB_HOST; ?>" class="w-full">
                        </div>

                        <div class="grid">
                            <label for="DB_NAME">Database Name</label>
                            <input id="DB_NAME" name="DB_NAME" value="<?= DB_NAME; ?>" class="w-full">
                        </div>

                        <div class="grid">
                            <label for="DB_USER">Database User</label>
                            <input id="DB_USER" name="DB_USER" value="<?= DB_USER; ?>" class="w-full">
                        </div>

                        <div class="grid">
                            <label for="DB_PASS">Database Password</label>
                            <input id="DB_PASS" name="DB_PASS" value="<?= DB_PASS; ?>" class="w-full">
                        </div>

                        <div class="grid">
                            <label for="DB_PORT">Database Port</label>
                            <input id="DB_PORT" name="DB_PORT" value="<?= DB_PORT; ?>" class="w-full">
                        </div>

                        <div class="grid">
                            <label for="DB_SOCKET">Database Socket</label>
                            <input id="DB_SOCKET" name="DB_SOCKET" value="<?= DB_SOCKET; ?>" class="w-full">
                        </div>

                        <div class="grid">
                            <label for="DB_PREFIX">Database Prefix</label>
                            <input id="DB_PREFIX" name="DB_PREFIX" value="<?= DB_PREFIX; ?>" class="w-full">
                        </div>
                    </div>
                    <button class="btn-green" id="submit" name="submit">Save</button>
                </form>
                <?php } else {
                    header('Location: / ');
                    exit;
                } ?>
            </main>
        </div>
    </body>
</html>
