<?php

use Vault\api\ApiError;

header('Content-Type: application/json; charset=utf-8');

$eh = new ApiError();

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
    $eh->missingData();
}
