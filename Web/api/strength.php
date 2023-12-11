<?php

use Vault\authentication\AuthenticationManager;
use Vault\data\DataManager;
use Vault\event\ErrorHandler;
use Vault\security\InputManager;

header('Content-Type: application/json; charset=utf-8');

$am = new AuthenticationManager();
if ($am->authenticated() && isset($_SESSION['user']) && isset($_SESSION['key'])) {
    if (isset($_GET['check'])) {
        $check = $_GET['check'];

        $score = 0;

        if (preg_match('@[A-Z]@', $check)) {
            $score++;
        }
        if (preg_match('@[a-z]@', $check)) {
            $score++;
        }
        if (preg_match('@[\d]@', $check)) {
            $score++;
        }
        if (preg_match('@[^\w]@', $check)) {
            $score++;
        }
        if (strlen($check) >= 8) {
            $score++;
        }
        if (strlen($check) >= 14) {
            $score++;
        }

        if (!str_contains(strtoupper($check), 'PASS')) {
            $score++;
        }
        if (!str_contains(strtoupper($check), 'ADMIN')) {
            $score++;
        }
        if (!str_contains(strtoupper($check), 'ROOT')) {
            $score++;
        }
        if (!str_contains(strtoupper($check), '1234')) {
            $score++;
        }

        echo '{"score": '.$score.'}';
    } else {
        $eh = new ErrorHandler();
        $eh->error('', '', '', 'Missing required data.', 400);
    }
} else {
    $eh = new ErrorHandler();
    $eh->unauthorised();
}
