<?php

header('Content-Type: application/json; charset=utf-8');
if (!file_exists(__DIR__.'/../run.json')) {
    echo '{"status":0}';
} else {
    echo '{"status":200}';
}