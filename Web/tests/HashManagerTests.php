<?php

declare(strict_types=1);
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../security/ValidationManager.php';
use PHPUnit\Framework\TestCase;
use Vault\security\ValidationManager;

final class HashManagerTests extends TestCase
{
    public function testBadPassword(): void
    {
        $vm = new ValidationManager();
        $test = $vm->validatePasswordStrength('password');

        $this->assertSame(false, $test);
    }

    public function testGoodPassword(): void
    {
        $vm = new ValidationManager();
        $test = $vm->validatePasswordStrength('t48hsagG!2');

        $this->assertSame(true, $test);
    }
}
