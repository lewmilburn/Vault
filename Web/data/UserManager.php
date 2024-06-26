<?php

namespace Vault\data;

class UserManager
{
    private string $userFile = __DIR__.'/../users.json';

    public function setLastChange($user, $time): bool
    {
        $users = file_get_contents($this->userFile);
        $users = json_decode($users);
        foreach ($users as $key => $item) {
            if ($item->user == $user) {
                $users[$key]->last_change = $time;

                return file_put_contents($this->userFile, json_encode($users));
            }
        }

        return false;
    }

    public function getLastChange($user): string|null
    {
        $users = file_get_contents($this->userFile);
        $users = json_decode($users);

        foreach ($users as $key => $item) {
            if ($item->user == $user) {
                if (!isset($users[$key]->last_change)) {
                    $users[$key]->last_change = date('Y-m-d H:i:s', strtotime('-1 hour'));
                    file_put_contents($this->userFile, json_encode($users));
                }

                return $users[$key]->last_change;
            }
        }

        return null;
    }
}
