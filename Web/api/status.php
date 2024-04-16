<?php

header('Content-Type: application/json; charset=utf-8');
if (!file_exists(__DIR__.'/../run.json')) {
    echo '{"status":500,"message":"Vault is not set up."}';
} else {
    echo '{"status":200}';
}
