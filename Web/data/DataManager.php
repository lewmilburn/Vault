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
        $vm->throwNull($username, 'getUserData');

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

    public function createUser(string $username, string $password, int $role): bool
    {
        $vm = new ValidationManager();
        $vm->throwNull($username, 'createUser');
        $vm->throwNull($password, 'createUser');

        $password = password_hash($password, PASSWORD_DEFAULT);
        $username = trim($username);

        $hm = new HashManager();
        $username = $hm->hashUser($username);

        $im = new InputManager();
        $username = $im->escapeString($username);
        $password = $im->escapeString($password);
        $role = $im->escapeString($role);

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

        return $dm->createUser($username, $password, $role);
    }

    public function createVault(string $username, string $password): void
    {
        $vm = new ValidationManager();
        $vm->throwNull($username, 'createVault');
        $vm->throwNull($password, 'createVault');

        $hm = new HashManager();
        $user = $hm->hashUser($username);

        $im = new InputManager();
        $user = $im->escapeString($user);
        $password = $im->escapeString($password);

        if (STORAGE_TYPE == DATABASE) {
            $dm = new DatabaseManager();
            $dm->createVault($user, $password);
        } elseif (STORAGE_TYPE == FILESYSTEM) {
            $fm = new FileManager();
            $fm->createVault($user, $password);
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

    public function getVault(string $user, string $key): array|null
    {
        $vm = new ValidationManager();
        $vm->throwNull($user, 'getVault');
        $vm->throwNull($key, 'getVault');

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

    public function addPassword(
        string $user,
        string $key,
        string $uniqueID,
        string $username,
        string $pass,
        string $name,
        string $url,
        string $notes
    ): bool {
        $im = new InputManager();
        $username = $im->escapeString($username);
        $pass = $im->escapeString($pass);
        $uniqueID = $im->escapeString($uniqueID);
        $name = $im->escapeString($name);
        $url = $im->escapeString($url);
        $notes = $im->escapeString($notes);
        $vault = $this->getVault($user, $key);

        $data = '{"pid":"'.$uniqueID.'","user":"'.$username.'","pass":"'.$pass.'","name":"'.$name.'","url":"'.$url.'","notes":"'.$notes.'"}';
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

        return $dm->saveVault($user, $key, $vault);
    }

    public function updatePassword(
        string $user,
        string $key,
        string $uniqueID,
        string $username,
        string $pass,
        string $name,
        string $url,
        string $notes
    ): bool {
        $im = new InputManager();
        $username = $im->escapeString($username);
        $pass = $im->escapeString($pass);
        $uniqueID = $im->escapeString($uniqueID);
        $name = $im->escapeString($name);
        $url = $im->escapeString($url);
        $notes = $im->escapeString($notes);

        $vault = $this->getVault($user, $key);

        foreach ($vault as $itemKey => $password) {
            if ($password->pid == $uniqueID) {
                unset($vault[$itemKey]);
            }
        }

        $data = '{"pid":"'.$uniqueID.'","user":"'.$username.'","pass":"'.$pass.'","name":"'.$name.'","url":"'.$url.'","notes":"'.$notes.'"}';
        $tempArray = json_decode($data);
        $vault[] = $tempArray;

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

        return $dm->saveVault($user, $key, $vault);
    }

    public function deletePassword(string $user, string $key, string $uniqueID): bool
    {
        $im = new InputManager();
        $uniqueID = $im->escapeString($uniqueID);

        $vault = $this->getVault($user, $key);

        foreach ($vault as $itemKey => $password) {
            if ($password->pid == $uniqueID) {
                unset($vault[$itemKey]);
                $vault = array_values($vault);
            }
        }

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

        return $dm->saveVault($user, $key, $vault);
    }
}
