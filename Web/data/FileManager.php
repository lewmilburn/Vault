<?php

namespace Vault\data;

use Vault\security\EncryptionManager;

class FileManager
{
    private string $usersFile;
    private string $defaultVault;

    public function __construct()
    {
        $this->usersFile = __DIR__.'/../'.SECURE_LOCATION.USERS_FILE;
        $this->defaultVault = __DIR__.'/../'.SECURE_LOCATION.DEFAULT_USER.'.vault';

        if (!file_exists($this->usersFile)) {
            $this->initialiseUsers();
        }

        if (!file_exists($this->defaultVault)) {
            $this->initialiseVault();
        }
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

    private function initialiseUsers(): void
    {
        $UserFile = fopen($this->usersFile, 'w');
        fwrite($UserFile, '[{"user":"admin","passkey":"'.password_hash(TEMPORARY_PASSWORD, PASSWORD_DEFAULT).'"}]');
        fclose($UserFile);
    }

    private function initialiseVault(): void
    {
        $VaultFile = fopen($this->defaultVault, 'w');

        $em = new EncryptionManager();
        $EncryptedData = $em->encrypt('[{}]', $em->generateKey(PASSWORD_DEFAULT));

        fwrite($VaultFile, $EncryptedData[0].FILE_SEPARATOR.$EncryptedData[1]);
        fclose($VaultFile);
    }
}
