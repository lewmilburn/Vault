<?php

use Vault\api\password\PasswordAPI;

require_once 'PasswordAPI.php';

$PAPI = new PasswordAPI();

if ($_POST['type'] == 'create') {
    $PAPI->create();
}

if ($_POST['type'] == 'update') {
    $PAPI->update();
}
