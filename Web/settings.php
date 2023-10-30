<?php

// DATA_TYPE - DEV or PROD
const ENV = DEV;

// ENCRYPTION_METHOD
const ENCRYPTION_METHOD = 'aes-256-ctr';

// STORAGE_TYPE = DATABASE or FILESYSTEM
const STORAGE_TYPE = FILESYSTEM;

// Filesystem storage settings
const USERS_FILE = 'users.json';
const VAULT_FILE = 'default.vault';

// Database storage settings
const DB_HOST = '';
const DB_NAME = '';
const DB_USER = '';
const DB_PASS = '';
const DB_PORT = '';
const DB_PREFIX = 'va_';