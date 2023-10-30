<?php

namespace Vault\data;

class dataManager
{
    private int $dataType;

    public function __construct()
    {
        require_once __DIR__.'/../settings.php';
        $this->dataType = DATA_TYPE;
    }

    /**
     * @throws \Exception Invalid data type.
     */
    public function getUserData(string $username)
    {
        if ($this->dataType == 1) {
            $dm = new databaseManager();
        } elseif ($this->dataType == 2) {
            $dm = new fileManager();
        } else {
            throw new \Exception('Data type is invalid.');
        }

        return $dm->getUserData($username);
    }
}
