<?php

// Global settings
const ENV = DEV; // DEV/PROD
const STORAGE_TYPE = FILESYSTEM; // FILESYSTEM/DATABASE
const ALLOW_REGISTRATION = false;

// Filesystem storage settings
const USERS_FILE = 'users.json';
const SECURE_LOCATION = ''; // relative to this file.
const FILE_SEPARATOR = '[SEP]';
const DEFAULT_HASH = 'sha3-512';
const USER_HASH = 'crc32';
const CHECKSUM_HASH = 'sha1';

// Database storage settings
const DB_HOST = '127.0.0.1';
const DB_NAME = 'vault';
const DB_USER = 'root';
const DB_PASS = '';
const DB_PORT = 3306;
const DB_SOCKET = null;
const DB_PREFIX = 'va_';
