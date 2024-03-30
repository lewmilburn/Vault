<?php

namespace Vault\test;

use Vault\authentication\SessionManager;
use Vault\authentication\TokenManager;

class Authentication
{
    public function __construct()
    {
        require_once __DIR__.'/../authentication/TokenManager.php';
        require_once __DIR__.'/../authentication/SessionManager.php';
    }

    private function testGenerateToken(): bool
    {
        $tm = new TokenManager();
        $token = $tm->generateToken('test1');

        return $tm->validToken($token, 'test1');
    }

    private function testActiveSession(): bool
    {
        $sm = new SessionManager();

        return $sm->active();
    }

    private function testEndSession(): bool
    {
        $sm = new SessionManager();

        return $sm->end();
    }

    public function run()
    {
        $pass = 0;

        if ($this->testGenerateToken()) {
            echo '[AUTHENTICATION][01/03] Passed';
            $pass++;
        } else {
            echo '[AUTHENTICATION][01/03] Failed';
        }
        echo PHP_EOL;

        if ($this->testActiveSession()) {
            echo '[AUTHENTICATION][02/03] Passed';
            $pass++;
        } else {
            echo '[AUTHENTICATION][02/03] Failed';
        }
        echo PHP_EOL;

        if ($this->testEndSession()) {
            echo '[AUTHENTICATION][03/03] Passed';
            $pass++;
        } else {
            echo '[AUTHENTICATION][03/03] Failed';
        }
        echo PHP_EOL;

        echo '[AUTHENTICATION] '.$pass.'/03 tests passed.'.PHP_EOL;

        return $pass;
    }
}
