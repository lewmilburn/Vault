<?php

/**
 * @author Lewis Milburn
 * @license Apache 2.0 International License
 */

ob_start();
session_start();

require_once __DIR__ . '/loader.php';

ob_end_flush();