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
        $userFile = fopen($this->usersFile, 'w');
        fwrite($userFile, '[{"user":"admin","passkey":"'.password_hash(TEMPORARY_PASSWORD, PASSWORD_DEFAULT).'"}]');
        fclose($userFile);
    }

    private function initialiseVault(): void
    {
        $vaultFile = fopen($this->defaultVault, 'w');

        $em = new EncryptionManager();
        $encryptedData = $em->encrypt('[{}]', $em->generateKey(PASSWORD_DEFAULT));

        fwrite($vaultFile, $encryptedData[0].FILE_SEPARATOR.$encryptedData[1]);
        fclose($vaultFile);
    }
}
