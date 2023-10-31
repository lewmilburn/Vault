<?php

namespace Vault\data;

class DataManager
{
    /**
     * @throws \Exception Invalid data type.
     */
    public function getUserData(string $username): object|null
    {
        if (STORAGE_TYPE == DATABASE) {
            $dm = new DatabaseManager();
        } elseif (STORAGE_TYPE == FILESYSTEM) {
            $dm = new FileManager();
        } else {
            throw new \Exception('Data type is invalid.');
        }

        return $dm->getUserData($username);
    }
}
