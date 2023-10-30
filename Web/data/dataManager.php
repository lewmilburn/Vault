<?php

namespace Vault\data;

class dataManager
{
    /**
     * @throws \Exception Invalid data type.
     */
    public function getUserData(string $username): string
    {
        if (STORAGE_TYPE == DATABASE) {
            $dm = new databaseManager();
        } elseif (STORAGE_TYPE == FILESYSTEM) {
            $dm = new fileManager();
        } else {
            throw new \Exception('Data type is invalid.');
        }

        return $dm->getUserData($username);
    }
}
