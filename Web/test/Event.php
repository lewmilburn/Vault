<?php

namespace Vault\test;

use Vault\authentication\AuthenticationManager;
use Vault\authentication\SessionManager;
use Vault\authentication\TokenManager;

class Event
{
    public function __construct()
    {
    }

    private function test(): bool
    {
        return true;
    }

    public function run()
    {
        $pass = 0;

        if ($this->test()) {
            echo '[EVENT][01/01] Passed';
            $pass++;
        } else {
            echo '[EVENT][01/01] Failed';
        }
        echo PHP_EOL;

        echo '[EVENT] 0'.$pass.'/01 tests passed.'.PHP_EOL;

        return $pass;
    }
}
