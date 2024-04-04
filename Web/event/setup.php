<?php

use Vault\data\DataManager;
use Vault\data\FileManager;
use Vault\security\InputManager;
use Vault\security\ValidationManager;
use Vault\SettingsManager;

$setup = true;
require_once __DIR__ . '/../autoload.php';

if (isset($_POST['user']) && isset($_POST['pass'])) {

    $im = new InputManager();
    $user = $im->escapeString($_POST['user']);
    $pass = $im->escapeString($_POST['pass']);

    $user = trim($user);
    $pass = trim($pass);

    $vm = new ValidationManager();
    if (!$vm->validatePasswordStrength($pass)) {
        header('Location: /?sf=pass');
        exit;
    }

    if (!$vm->validateUsername($user)) {
        header('Location: /?sf=user');
        exit;
    }

    $im = new InputManager();
    $sm = new SettingsManager();

    $env = $im->escapeString($_POST['ENV']);
    if ($env !== 'DEV' && $env !== 'PROD') {
        header('Location: /?sfr=Invalid environment.');
        exit;
    }

    $storage_type = $im->escapeString($_POST['STORAGE_TYPE']);
    if ($storage_type !== 'FILESYSTEM' && $storage_type !== 'DATABASE') {
        header('Location: /?sfr=Invalid storage type.');
        exit;
    }

    $allow_registration = $im->escapeString($_POST['ALLOW_REGISTRATION']);
    if ($allow_registration !== 'true' && $allow_registration !== 'false') {
        header('Location: /?sfr=Invalid registration option.');
        exit;
    }

    $users_file = $im->escapeString($_POST['USERS_FILE']);
    if (!file_exists(__DIR__ . '/../' . $users_file)) {
        header('Location: /?sfr=Users file does not exist, please create it first then set it as the users file.');
        exit;
    }

    $secure_location = $im->escapeString($_POST['SECURE_LOCATION']);
    if (!is_dir(__DIR__ . '/../' . $secure_location)) {
        header('Location: /?sfr=Secure location does not exist, please create it first then set it as the secure location.');
        exit;
    }

    $file_separator = $im->escapeString($_POST['FILE_SEPARATOR']);
    if ($file_separator == '' || $file_separator == '$') {
        header('Location: /?sfr=Invalid file separator.');
        exit;
    }

    $default_hash = $im->escapeString($_POST['DEFAULT_HASH']);
    if (!in_array($default_hash, SECURE_HASHES)) {
        header('Location: /?sfr=Invalid default hash.');
        exit;
    }

    $user_hash = $im->escapeString($_POST['USER_HASH']);
    if (!in_array($user_hash, USER_HASHES)) {
        header('Location: /?sfr=Invalid user hash.');
        exit;
    }

    $checksum_hash = $im->escapeString($_POST['CHECKSUM_HASH']);
    if (!in_array($checksum_hash, CHECKSUM_HASHES)) {
        header('Location: /?sfr=Invalid checksum hash.');
        exit;
    }

    $db_host = $im->escapeString($_POST['DB_HOST']);
    $db_name = $im->escapeString($_POST['DB_NAME']);
    $db_user = $im->escapeString($_POST['DB_USER']);
    $db_pass = $im->escapeString($_POST['DB_PASS']);
    $db_port = $im->escapeString($_POST['DB_PORT']);
    $db_socket = $im->escapeString($_POST['DB_SOCKET']);
    $db_prefix = $im->escapeString($_POST['DB_PREFIX']);

    $sm->update(
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
    );

    $dm = new DataManager();
    if (!$dm->createUser($user, $pass, 1)) {
        header('Location: /?sf=userExists');
        exit;
    }

    $dm->createVault($user, $pass);

    $fm = new FileManager();
    file_put_contents(__DIR__ . '/../run.json', '{"config":true}');

    header('Location: /?sc');
} else { ?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vault</title>
        <?php require_once __DIR__.'/../view/common/head.php'; ?>
    </head>
    <body>
        <?php require_once __DIR__.'/../view/common/alerts.php'; ?>

        <?php if (isset($_GET['sf']) && $_GET['sf'] == 'userExists') { ?>
            <div class="alert-red">
                Setup failed, a user with this account name already exists.
            </div>
        <?php } ?>
        <?php if (isset($_GET['sf']) && $_GET['sf'] == 'pass') { ?>
            <div class="alert-red">
                Your password must contain 8 characters,
                including at least 1 uppercase,
                1 lowercase, 1 number, and 1 symbol.
            </div>
        <?php } ?>
        <?php if (isset($_GET['sf']) && $_GET['sf'] == 'user') { ?>
            <div class="alert-red">
                Your username must be at least 4 characters
                and can not include any symbols.
            </div>
        <?php } ?>
        <?php if (isset($_GET['sfr'])) { ?>
            <div class="alert-red">
                <?= htmlspecialchars($_GET['sfr']); ?>
            </div>
        <?php } ?>

        <header>
            <h1>Setup Vault.</h1>
            <p>Please create an account.</p>
        </header>

        <main>
            <form action="/" method="post" class="text-center sm:w-1/2 md:w-1/3 lg:w-1/4 mx-auto">
                <div class="grid gap-2">
                    <h2>Administrator Account</h2>
                    <p class="text-center">
                        This account will be the administrator for the instance.
                        We recommend creating a separate account to store your own passwords if this is a public site.
                    </p>
                    <div class="grid">
                        <label for="user">Admin Username</label>
                        <input id="user" name="user">
                    </div>
                    <div class="grid">
                        <label for="pass">Admin Password</label>
                        <input id="pass" name="pass" type="password">
                    </div>

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
                <button type="submit" class="btn-primary">Finish Setup</button>
            </form>
        </main>
    </body>
</html>
<?php } ?>

