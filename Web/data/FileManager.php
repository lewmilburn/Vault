<?php

namespace Vault\data;

use Vault\event\ErrorHandler;
use Vault\security\EncryptionManager;

class FileManager
{
    private string $usersFile;
    private string $defaultVault;

    public function __construct()
    {
        $this->usersFile = __DIR__.'/../'.SECURE_LOCATION.USERS_FILE;
        $this->defaultVault = __DIR__.'/../'.SECURE_LOCATION.DEFAULT_USER.'.vault';
    }

    public function getUserData(string $username): object|null
    {
        $usersFile = file_get_contents($this->usersFile);
        $users = json_decode($usersFile);
        foreach ($users as $user) {
            if ($user->user == $username) {
                return $user;
            }
        }

        return null;
    }

    public function initialiseFileSystem($tempPassword): void
    {
        if (!file_exists($this->usersFile)) {
            $this->initialiseUsers($tempPassword);
        }

        if (!file_exists($this->defaultVault)) {
            $this->initialiseVault($tempPassword);
        }
    }

    private function initialiseUsers($tempPassword): void
    {
        $userFile = fopen($this->usersFile, 'w');
        fwrite($userFile, '[{"user":"admin","passkey":"'.password_hash($tempPassword, PASSWORD_DEFAULT).'"}]');
        fclose($userFile);
    }

    private function initialiseVault(string $tempPassword): void
    {
        $vaultFile = fopen($this->defaultVault, 'w');

        $em = new EncryptionManager();
        $encryptedData = $em->encrypt('[{}]', $em->generateKey($tempPassword));

        fwrite($vaultFile, $encryptedData[0].FILE_SEPARATOR.$encryptedData[1]);
        fclose($vaultFile);
    }
}
