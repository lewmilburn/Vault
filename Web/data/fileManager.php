<?php

namespace Vault\data;

use Vault\encryption\encryptionManager;

class fileManager
{
    private string $usersFile;
    private string $vaultFile;

    public function __construct()
    {
        $this->usersFile = __DIR__ . '/../' . USERS_FILE;
        $this->vaultFile = __DIR__ . '/../' . VAULT_FILE;

        if (!file_exists($this->usersFile)) {
            $this->initialiseUsers();
        }

        if (!file_exists($this->vaultFile)) {
            $this->initialiseVault();
        }
    }

    public function getUserData(string $username)
    {
        $usersFile = file_get_contents($this->usersFile);
        return json_decode($usersFile);
    }

    private function initialiseUsers(): void
    {
        $UserFile = fopen($this->usersFile, "w");
        fwrite($UserFile, '{"users" : []}');
        fclose($UserFile);
    }

    private function initialiseVault(): void
    {
        $VaultFile = fopen($this->vaultFile, "w");

        $em = new encryptionManager();
        $EncryptedData = $em->encrypt('"users" : []',$em->generateKey(TEMPORARY_PASSWORD));

        fwrite($VaultFile, $EncryptedData[0].'[!]'.$EncryptedData[1]);
        fclose($VaultFile);
    }
}
