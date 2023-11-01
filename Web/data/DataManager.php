<?php

namespace Vault\data;

use Vault\event\ErrorHandler;
use Vault\security\HashManager;
use Vault\security\InputManager;

class DataManager
{
    public string $invalidStorageError = 'Selected storage type is invalid, please use DATABASE or FILESYSTEM.';

    public function getUserData(string $username): object|null
    {
        $username = trim($username);

        $hm = new HashManager();
        $username = $hm->hashUser($username);

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

        return $dm->getUserData($username);
    }

    public function createUser(string $username, string $password): bool
    {
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

        $dm->createVault($username, $password);
    }
}
