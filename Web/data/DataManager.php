<?php

namespace Vault\data;

use Vault\event\ErrorHandler;
use Vault\security\HashManager;
use Vault\security\InputManager;
use Vault\security\ValidationManager;

class DataManager
{
    public string $invalidStorageError = 'Selected storage type is invalid, please use DATABASE or FILESYSTEM.';

    public function getUserData(string $username): object|null
    {
        $vm = new ValidationManager();
        $vm->throwNull($username);

        $username = trim($username);

        $hm = new HashManager();
        $user = $hm->hashUser($username);

        if (STORAGE_TYPE == DATABASE) {
            $dm = new DatabaseManager();
        } elseif (STORAGE_TYPE == FILESYSTEM) {
            $dm = new FileManager();
        } else {
            $em = new ErrorHandler();
            $em->error(
                'data',
                'DataManager',
                'getUserData',
                $this->invalidStorageError,
                '500'
            );
        }

        return $dm->getUserData($user);
    }

    public function createUser(string $username, string $password): bool
    {
        $vm = new ValidationManager();
        $vm->throwNull($username);
        $vm->throwNull($password);

        $password = password_hash($password, PASSWORD_DEFAULT);
        $username = trim($username);

        $hm = new HashManager();
        $username = $hm->hashUser($username);

        $im = new InputManager();
        $username = $im->escapeString($username);
        $password = $im->escapeString($password);

        if (STORAGE_TYPE == DATABASE) {
            $dm = new DatabaseManager();
        } elseif (STORAGE_TYPE == FILESYSTEM) {
            $dm = new FileManager();
        } else {
            $em = new ErrorHandler();
            $em->error(
                'data',
                'DataManager',
                'createUser',
                $this->invalidStorageError,
                '500'
            );
        }

        return $dm->createUser($username, $password);
    }

    public function createVault(string $username, string $password): void
    {
        $vm = new ValidationManager();
        $vm->throwNull($username);
        $vm->throwNull($password);

        $hm = new HashManager();
        $username = $hm->hashUser($username);

        $im = new InputManager();
        $username = $im->escapeString($username);
        $password = $im->escapeString($password);

        if (STORAGE_TYPE == DATABASE) {
            $dm = new DatabaseManager();
            $dm->createVault();
        } elseif (STORAGE_TYPE == FILESYSTEM) {
            $fm = new FileManager();
            $fm->createVault($username, $password);
        } else {
            $em = new ErrorHandler();
            $em->error(
                'data',
                'DataManager',
                'createUser',
                $this->invalidStorageError,
                '500'
            );
        }
    }

    public function getVault(string $user, string $key): array|string|null
    {
        $vm = new ValidationManager();
        $vm->throwNull($user);
        $vm->throwNull($key);

        $im = new InputManager();
        $user = $im->escapeString($user);

        if (STORAGE_TYPE == DATABASE) {
            $dm = new DatabaseManager();
        } elseif (STORAGE_TYPE == FILESYSTEM) {
            $dm = new FileManager();
        } else {
            $em = new ErrorHandler();
            $em->error(
                'data',
                'DataManager',
                'getVault',
                $this->invalidStorageError,
                '500'
            );
        }

        return $dm->getVault($user, $key);
    }

    public function addPassword(string $user, string $key, string $username, string $pass, string $name, string $url, string $notes)
    {
        $vault = $this->getVault($user, $key);

        $data = '{"user":"'.$username.'","pass":"'.$pass.'","name":"'.$name.'","url":"'.$url.'","notes":"'.$notes.'"}';
        $tempArray = json_decode($data, true);
        array_push($vault, $tempArray);

        $vault = json_encode($vault);

        if (STORAGE_TYPE == DATABASE) {
            $dm = new DatabaseManager();
        } elseif (STORAGE_TYPE == FILESYSTEM) {
            $dm = new FileManager();
        } else {
            $em = new ErrorHandler();
            $em->error(
                'data',
                'DataManager',
                'getVault',
                $this->invalidStorageError,
                '500'
            );
        }
        $dm->saveVault($user, $key, $vault);
    }
}
