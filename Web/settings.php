<?php

// DATA_TYPE - DEV or PROD
const ENV = DEV;

// STORAGE_TYPE = DATABASE or FILESYSTEM
const STORAGE_TYPE = FILESYSTEM;

// Filesystem storage settings
const USERS_FILE = 'users.json';
const DEFAULT_USER = 'admin';
// TEMPORARY_PASSWORD - first run password
const TEMPORARY_PASSWORD = 'Vault123!';
const SECURE_LOCATION = ''; // relative to this file.
const FILE_SEPARATOR = '[SEP]';

// Database storage settings
const DB_HOST = '';
const DB_NAME = '';
const DB_USER = '';
const DB_PASS = '';
const DB_PORT = '';
const DB_PREFIX = 'va_';
