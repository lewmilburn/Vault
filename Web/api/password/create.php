<?php

use Vault\data\DataManager;

$dm = new DataManager();
$dm->addPassword($_SESSION['user'], $_SESSION['key'], $_POST['user'], $_POST['pass'], $_POST['name'], $_POST['url'], $_POST['notes']);

header('Location: /');
exit;