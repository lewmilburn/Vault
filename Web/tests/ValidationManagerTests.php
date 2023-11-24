<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Vault\security\HashManager;
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../data/const.php';
require __DIR__ . '/../settings.php';
require __DIR__ . '/../security/HashManager.php';

final class ValidationManagerTests extends TestCase
{
    public function testHashString(): void
    {
        $hm = new HashManager();
        $test = $hm->hashString('password');

        $expected = 'e9a75486736a550af4fea861e2378305c4a555a05094dee1dca2f68afea49cc3a50e8de6ea131ea521311f4d6fb054a146e8282f8e35ff2e6368c1a62e909716';

        $this->assertSame($expected, $test);
    }

    public function testHashUser(): void
    {
        $hm = new HashManager();
        $test = $hm->hashUser('user');

        $expected = '7e1fbe19';

        $this->assertSame($expected, $test);
    }

    public function testGenerateChecksum(): void
    {
        $hm = new HashManager();
        $test = $hm->generateChecksum('checksumMe!');

        $expected = 'bc51926a29dd071c4d6016e863eeffca14d78cdb';

        $this->assertSame($expected, $test);
    }
}
