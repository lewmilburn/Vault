<?php

namespace Vault\data;

use Vault\security\InputManager;

class SettingsManager
{
    public function update(
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
    ): bool|int {
        $data = "<?php
const ENV = {$env};
const STORAGE_TYPE = {$storage_type};
const ALLOW_REGISTRATION = {$allow_registration};
const USERS_FILE = '{$users_file}';
const SECURE_LOCATION = '{$secure_location}';
const FILE_SEPARATOR = '{$file_separator}';
const DEFAULT_HASH = '{$default_hash}';
const USER_HASH = '{$user_hash}';
const CHECKSUM_HASH = '{$checksum_hash}';
const DB_HOST = '{$db_host}';
const DB_NAME = '{$db_name}';
const DB_USER = '{$db_user}';
const DB_PASS = '{$db_pass}';
const DB_PORT = {$db_port};
const DB_SOCKET = '{$db_socket}';
const DB_PREFIX = '{$db_prefix}';";

        return file_put_contents(__DIR__.'/../settings.php', $data);
    }

    public function updateFromPost(): string|null
    {
        $im = new InputManager();

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

        if (!$this->update(
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
            return 'Unable to update file.';
        }

        return null;
    }
}
