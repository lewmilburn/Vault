<?php

namespace Vault\data;

class UserManager
{
    private string $userFile = __DIR__ . '/../users.json';
    function setLastSync($user): bool {
        $users = file_get_contents($this->userFile);
        $users = json_encode($users);
        $users['$user']->last_sync = date('Y-m-d');

        return file_put_contents($this->userFile, $users);
    }
    function getLastSync($user): string {
        $users = file_get_contents($this->userFile);
        $users = json_encode($users);

        return $users['$user']->last_sync;
    }
}