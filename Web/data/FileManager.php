<?php

namespace Vault\data;

use Vault\security\EncryptionManager;

class FileManager
{
    private string $usersFile;
    private string $secureLocation;
    private string $vaultExt = '.vault';

    public function __construct()
    {
        $this->usersFile = __DIR__.'/../'.SECURE_LOCATION.USERS_FILE;
        $this->secureLocation = __DIR__.'/../'.SECURE_LOCATION;
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

    public function createUser(string $username, string $password): bool
    {
        if (file_exists($this->usersFile)) {
            $usersFile = file_get_contents($this->usersFile);
            $data = json_decode($usersFile);

            foreach ($data as $user) {
                if ($user->user == $username) {
                    return false;
                }
            }

            $newUser = '{"user":"'.$username.'","pass":"'.$password.'"}';
            $newUser = json_decode($newUser);

            $data[] = $newUser;

            $data = json_encode($data);
        } else {
            $data = '[{"user":"'.$username.'","pass":"'.$password.'"}]';
        }

        $usersFile = fopen($this->usersFile, 'w');
        fwrite($usersFile, $data);
        fclose($usersFile);

        return true;
    }

    public function createVault(string $user, string $key): void
    {
        $file = $this->secureLocation.$user.$this->vaultExt;

        $vaultFile = fopen($file, 'w');

        $em = new EncryptionManager();
        $encryptedData = $em->encrypt('[]', $em->generateKey($user, $key));

        fwrite($vaultFile, $encryptedData[0].FILE_SEPARATOR.$encryptedData[1]);
        fclose($vaultFile);
    }

    public function getVault(string $user, string $key): array|null
    {
        $file = $this->secureLocation.$user.$this->vaultExt;

        $em = new EncryptionManager();
        $data = file_get_contents($file);

        return (array) json_decode($em->decrypt($data, $key));
    }

    public function saveVault(string $user, string $key, mixed $data): bool
    {
        $file = $this->secureLocation.$user.$this->vaultExt;

        $vaultFile = fopen($file, 'w');

        $em = new EncryptionManager();
        $encryptedData = $em->encrypt($data, $key);

        if (!fwrite($vaultFile, $encryptedData[0] . FILE_SEPARATOR . $encryptedData[1])) {
            fclose($vaultFile);
            return false;
        } else {
            fclose($vaultFile);
            return true;
        }
    }
}
