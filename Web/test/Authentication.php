<?php

namespace Vault\test;

use Vault\authentication\AuthenticationManager;
use Vault\authentication\SessionManager;
use Vault\authentication\TokenManager;

class Authentication
{
    public function __construct()
    {
        require_once __DIR__.'/../authentication/TokenManager.php';
        require_once __DIR__.'/../authentication/SessionManager.php';
        require_once __DIR__.'/../authentication/AuthenticationManager.php';
        require_once __DIR__.'/../data/DataManager.php';
        require_once __DIR__.'/../data/FileManager.php';
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

    private function testLogin(): bool
    {
        $am = new AuthenticationManager();

        return $am->login('test', 'test');
    }

    private function testAuthenticated(): bool
    {
        $am = new AuthenticationManager();

        return $am->authenticated();
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
            echo '[AUTHENTICATION][01/05] Passed';
            $pass++;
        } else {
            echo '[AUTHENTICATION][01/05] Failed';
        }
        echo PHP_EOL;

        if ($this->testActiveSession()) {
            echo '[AUTHENTICATION][02/05] Passed';
            $pass++;
        } else {
            echo '[AUTHENTICATION][02/05] Failed';
        }
        echo PHP_EOL;

        if (!$this->testLogin()) {
            echo '[AUTHENTICATION][03/05] Passed';
            $pass++;
        } else {
            echo '[AUTHENTICATION][03/05] Failed';
        }
        echo PHP_EOL;

        if (!$this->testAuthenticated()) {
            echo '[AUTHENTICATION][04/05] Passed';
            $pass++;
        } else {
            echo '[AUTHENTICATION][04/05] Failed';
        }
        echo PHP_EOL;

        if ($this->testEndSession()) {
            echo '[AUTHENTICATION][05/05] Passed';
            $pass++;
        } else {
            echo '[AUTHENTICATION][05/05] Failed';
        }
        echo PHP_EOL;

        echo '[AUTHENTICATION] 0'.$pass.'/05 tests passed.'.PHP_EOL;

        return $pass;
    }
}
