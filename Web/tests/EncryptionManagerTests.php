<?php

declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../data/const.php';
require __DIR__.'/../settings.php';
require __DIR__.'/../security/EncryptionManager.php';
require __DIR__.'/../security/ValidationManager.php';
use PHPUnit\Framework\TestCase;
use Vault\security\EncryptionManager;

final class EncryptionManagerTests extends TestCase
{
    public function testEncryption(): void
    {
        $string = 'Hello there!';
        $em = new EncryptionManager();
        $key = $em->generateKey('user', 'password');
        $encrypted = $em->encrypt($string, $key);
        $encrypted = $encrypted[0].FILE_SEPARATOR.$encrypted[1];
        $decrypted = $em->decrypt($encrypted, $key);

        $this->assertSame($string, $decrypted);
    }
}
