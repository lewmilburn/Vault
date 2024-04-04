<?php

namespace Vault;

class SettingsManager {
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
    ): bool|int
    {
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
        return file_put_contents(__DIR__ . '/../settings.php', $data);
    }
}
