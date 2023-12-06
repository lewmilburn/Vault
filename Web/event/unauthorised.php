<?php

use Vault\event\ErrorHandler;

$eh = new ErrorHandler();
$eh->error('event', '', '', 'Unauthorised',403);