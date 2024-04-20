<?php

use Vault\authentication\AuthenticationManager;use Vault\data\DataManager;
use Vault\data\FileManager;
use Vault\Libraries\PHPGangsta_GoogleAuthenticator;use Vault\security\InputManager;
use Vault\security\ValidationManager;
use Vault\data\SettingsManager;

$setup = true;
require_once __DIR__ . '/../autoload.php';

$factor = new PHPGangsta_GoogleAuthenticator();

if (isset($_POST['user']) && isset($_POST['pass'])) {

    if (!$factor->verifyCode($_POST['secret'], $_POST['code'])) {
        header('Location: /?sf=code');
        exit;
    }

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

    $result = $sm->updateFromPost();
    if ($result !== null) {
        header('Location: /?sfr='.$result);
        exit;
    }

    $dm = new DataManager();
    if (!$dm->createUser($user, $pass, 1, $_POST['secret'])) {
        header('Location: /?sf=userExists');
        exit;
    }

    $dm->createVault($user, $pass);

    $fm = new FileManager();
    file_put_contents(__DIR__ . '/../run.json', '{"config":true}');

    $auth = new AuthenticationManager();
    $auth->login($user,$pass,htmlspecialchars($_POST['code']));

    header('Location: /?sc');
} else {
$secret = $factor->createSecret();
$qr = $factor->getQRCodeGoogleUrl($_SERVER['SERVER_NAME'], $secret, 'Vault');

?><!DOCTYPE html>
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
        <?php if (isset($_GET['sf']) && $_GET['sf'] == 'code') { ?>
            <div class="alert-red">
                Invalid two-factor authentication code.
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
                    <h2>Your Account: Login Information</h2>
                    <p class="text-center alert-yellow">
                        This account will be the administrator for the instance.
                        We recommend creating a separate account to store your own passwords if this is a public site.
                    </p>
                    <div class="hidden">
                        <input id="secret" name="secret" value="<?= $secret; ?>">
                    </div>
                    <div class="grid">
                        <label for="user">Admin Username</label>
                        <input id="user" name="user">
                    </div>
                    <div class="grid">
                        <label for="pass">Admin Password</label>
                        <input id="pass" name="pass" type="password">
                    </div>
                    <p class="alert-red mb-6">
                        Warning: Make a note of your password in a safe, secure place. For security reasons, it is not
                        possible to change your password unless you are logged in, and changing your password will clear
                        your Vault.
                    </p>

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
                                    value="false"<?php if (!ALLOW_REGISTRATION) { ?> selected<?php } ?>
                            >
                                No
                            </option>
                        </select>
                    </div>

                    <div class="grid">
                        <div class="grid">
                            <label for="WHITELIST">Whitelist</label>
                            <input
                                    id="WHITELIST"
                                    name="WHITELIST"
                                    value="<?php if (trim(WHITELIST) !== "") { echo WHITELIST; } ?>"
                                    class="w-full"
                                    placeholder="Disabled. To enable enter comma separated IPs."
                            >
                        </div>
                        <sub>Your IP: <?= htmlspecialchars($_SERVER['REMOTE_ADDR']); ?></sub>
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
                <br>
                <div class="grid gap-2">
                    <h2>Your Account: 2-Factor Authentication</h2>
                    <div class="grid">
                        <label>Scan the QR Code below on Google Authenticator to generate a 2FA Code</label>
                        <img src="<?= $qr; ?>" class="mx-auto" alt="Two-factor Authentication QR Setup">
                    </div>
                    <p class="alert-red mb-6">
                        Ensure you have enough time remaining on the token before you finish setup.
                    </p>
                    <div class="grid">
                        <label for="code">2FA Code</label>
                        <input id="code" name="code" type="password">
                    </div>
                </div>
                <button type="submit" class="btn-primary">Finish Setup</button>
            </form>
        </main>
    </body>
</html>
<?php } ?>

