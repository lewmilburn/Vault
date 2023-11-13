<?php

namespace Vault\data;

use Vault\security\EncryptionManager;

class FileManager
{
    private string $usersFile;
    private string $secureLocation;

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
        $file = $this->secureLocation.$user.'.vault';

        $vaultFile = fopen($file, 'w');

        $em = new EncryptionManager();
        $encryptedData = $em->encrypt('[{}]', $em->generateKey($user, $key));

        fwrite($vaultFile, $encryptedData[0].FILE_SEPARATOR.$encryptedData[1]);
        fclose($vaultFile);
    }

    public function getVault(string $user, string $key): string|null
    {
        $file = $this->secureLocation.$user.'.vault';

        $em = new EncryptionManager();
        $data = file_get_contents($file);

        return $em->decrypt($data,$key);
    }
}
