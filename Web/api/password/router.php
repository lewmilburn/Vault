<?php

if ($_POST['type'] == 'create') {
    require_once 'create.php';
}

if ($_POST['type'] == 'update') {
    require_once 'update.php';
}