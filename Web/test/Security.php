<?php

namespace Vault\test;

use Vault\security\EncryptionManager;
use Vault\security\HashManager;
use Vault\security\InputManager;
use Vault\security\ValidationManager;

class Security
{
    public function __construct()
    {
        require_once __DIR__ . '/../security/EncryptionManager.php';
        require_once __DIR__ . '/../security/HashManager.php';
        require_once __DIR__ . '/../security/InputManager.php';
        require_once __DIR__ . '/../security/ValidationManager.php';
    }

    private function testGenerateKey(): bool
    {
        $em = new EncryptionManager();
        $key = $em->generateKey('test1', 'test2');
        return $key != false;
    }

    private function testEncryptDecrypt($toEncrypt): string
    {
        $em = new EncryptionManager();
        $key = $em->generateKey('test1', 'test2');
        $encrypted = $em->encrypt($toEncrypt, $key);
        return $em->decrypt($encrypted[0] . FILE_SEPARATOR . $encrypted[1], $key);
    }

    private function testHashString($toHash): string
    {
        $hm = new HashManager();
        return $hm->hashString($toHash);
    }

    private function testHashUser($toHash): string
    {
        $hm = new HashManager();
        return $hm->hashUser($toHash);
    }

    private function testGenerateUniqueId($toID): string
    {
        $hm = new HashManager();
        return $hm->generateUniqueId($toID);
    }

    private function testGenerateChecksum($toGenerate): string
    {
        $hm = new HashManager();
        return $hm->generateChecksum($toGenerate);
    }

    private function testEscapeString($toEscape): string
    {
        $im = new InputManager();
        return $im->escapeString($toEscape);
    }

    private function testStripSlashes($toStrip): string
    {
        $im = new InputManager();
        return $im->stripSlashes($toStrip);
    }

    private function testValidatePasswordStrength($password): bool
    {
        $vm = new ValidationManager();
        return $vm->validatePasswordStrength($password);
    }

    private function testValidateUsername($username): bool
    {
        $vm = new ValidationManager();
        return $vm->validateUsername($username);
    }

    private function testCSRF($username): bool
    {
        $vm = new ValidationManager();
        return $vm->csrfValidate($vm->csrfToken());
    }

    private function testIsNull(): bool
    {
        $vm = new ValidationManager();
        return $vm->isNull(null);
    }

    private function testIsEmpty(): bool
    {
        $vm = new ValidationManager();
        return $vm->isNull('');
    }

    public function run()
    {
        $pass = 0;

        if ($this->testGenerateKey()) {
            echo '[SECURITY][01/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][01/13] Failed';
        }
        echo PHP_EOL;

        if ($this->testEncryptDecrypt('Test123') === 'Test123') {
            echo '[SECURITY][02/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][02/13] Failed';
        }
        echo PHP_EOL;

        if ($this->testHashString('Test123') === '68644f3dd172089ae9a650e582ae4759df2ed943291b70729abbc96bca2521ac34f2fad8971c50210e173bd506f3c8e4260f932fd99c3b59c1884fd816cb24ee') {
            echo '[SECURITY][03/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][03/13] Failed';
        }
        echo PHP_EOL;

        if ($this->testHashUser('Test123') === '90b89579') {
            echo '[SECURITY][04/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][04/13] Failed';
        }
        echo PHP_EOL;

        if ($this->testGenerateUniqueId('Test123') !== null) {
            echo '[SECURITY][05/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][05/13] Failed';
        }
        echo PHP_EOL;

        if ($this->testGenerateChecksum('Test123') === '8308651804facb7b9af8ffc53a33a22d6a1c8ac2') {
            echo '[SECURITY][06/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][06/13] Failed';
        }
        echo PHP_EOL;

        if ($this->testEscapeString('"\'') === '&quot;&#039;') {
            echo '[SECURITY][07/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][07/13] Failed';
        }
        echo PHP_EOL;

        if ($this->testStripSlashes('\\"') === '"') {
            echo '[SECURITY][08/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][08/13] Failed';
        }
        echo PHP_EOL;

        if (!$this->testValidatePasswordStrength('')) {
            echo '[SECURITY][09/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][09/13] Failed';
        }
        echo PHP_EOL;

        if ($this->testValidateUsername('test')) {
            echo '[SECURITY][10/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][10/13] Failed';
        }
        echo PHP_EOL;

        if ($this->testCSRF('test')) {
            echo '[SECURITY][11/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][11/13] Failed';
        }
        echo PHP_EOL;

        if ($this->testIsNull()) {
            echo '[SECURITY][12/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][12/13] Failed';
        }
        echo PHP_EOL;

        if ($this->testIsEmpty()) {
            echo '[SECURITY][13/13] Passed';
            $pass++;
        } else {
            echo '[SECURITY][13/13] Failed';
        }
        echo PHP_EOL;

        echo '[SECURITY] ' . $pass . '/13 tests passed.' . PHP_EOL;

        return $pass;
    }
}
