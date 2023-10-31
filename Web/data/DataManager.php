<?php

namespace Vault\data;

use Vault\event\ErrorHandler;

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
            $em = new ErrorHandler();
            $em->error('data', 'DataManager', 'getUserData', 'Selected storage type is invalid, please use DATABASE or FILESYSTEM.', '500');
        }

        return $dm->getUserData($username);
    }
}
