<?php
use Vault\security\InputManager;
use Vault\SettingsManager;

$error = null;

function updateSettings(): string|null
{
    $im = new InputManager();
    $sm = new SettingsManager();

    $env = $im->escapeString($_POST['ENV']);
    if ($env !== 'DEV' && $env !== 'PROD') {
        return 'Invalid environment.';
    }

    $storage_type = $im->escapeString($_POST['STORAGE_TYPE']);
    if ($storage_type !== 'FILESYSTEM' && $storage_type !== 'DATABASE') {
        return 'Invalid storage type.';
    }

    $allow_registration = $im->escapeString($_POST['ALLOW_REGISTRATION']);
    if ($allow_registration !== 'true' && $allow_registration !== 'false') {
        return 'Invalid registration option.';
    }

    $users_file = $im->escapeString($_POST['USERS_FILE']);
    if (!file_exists(__DIR__ . '/../' . $users_file)) {
        return 'Users file does not exist, please create it first then set it as the users file.';
    }

    $secure_location = $im->escapeString($_POST['SECURE_LOCATION']);
    if (!is_dir(__DIR__ . '/../' . $secure_location)) {
        return 'Secure location does not exist, please create it first then set it as the secure location.';
    }

    $file_separator = $im->escapeString($_POST['FILE_SEPARATOR']);
    if ($file_separator == '' || $file_separator == '$') {
        return 'Invalid file separator.';
    }

    $default_hash = $im->escapeString($_POST['DEFAULT_HASH']);
    if (!in_array($default_hash, SECURE_HASHES)) {
        return 'Invalid default hash.';
    }

    $user_hash = $im->escapeString($_POST['USER_HASH']);
    if (!in_array($user_hash, USER_HASHES)) {
        return 'Invalid user hash.';
    }

    $checksum_hash = $im->escapeString($_POST['CHECKSUM_HASH']);
    if (!in_array($checksum_hash, CHECKSUM_HASHES)) {
        return 'Invalid checksum hash.';
    }

    $db_host = $im->escapeString($_POST['DB_HOST']);
    $db_name = $im->escapeString($_POST['DB_NAME']);
    $db_user = $im->escapeString($_POST['DB_USER']);
    $db_pass = $im->escapeString($_POST['DB_PASS']);
    $db_port = $im->escapeString($_POST['DB_PORT']);
    $db_socket = $im->escapeString($_POST['DB_SOCKET']);
    $db_prefix = $im->escapeString($_POST['DB_PREFIX']);

    if (!$sm->update(
        $env,
        $storage_type,
        $allow_registration,
        $users_file,
        $secure_location,
        $file_separator,
        $default_hash,
        $user_hash,
        $checksum_hash,
        $db_host,
        $db_name,
        $db_user,
        $db_pass,
        $db_port,
        $db_socket,
        $db_prefix
    )) {
        return 'Unable to save to file.';
    } else {
        return null;
    }
}

if (isset($_POST['submit'])) {
    $error = updateSettings();
    if ($error == null) {
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
        <nav class="flex flex-col bg-blue-700 p-0">
            <i class="fa-solid fa-house btn-sidebar" title="Dashboard" onclick="window.location = '/'"></i>
            <i class="fa-solid fa-cog btn-sidebar" title="Settings" onclick="window.location = '/settings'"></i>
            <span class="flex-grow"></span>
            <i class="fa-solid fa-lock btn-sidebar" title="Secured with AEAD Encryption"></i>
        </nav>
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
                                <option value="DEV"<?php if (ENV==DEV) { ?> selected<?php } ?>>Development</option>
                                <option value="PROD"<?php if (ENV==PROD) { ?> selected<?php } ?>>Production (Recommended)</option>
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
