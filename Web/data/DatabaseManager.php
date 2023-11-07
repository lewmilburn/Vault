<?php

namespace Vault\data;

use mysqli;
use mysqli_sql_exception;
use Vault\event\ErrorHandler;

class DatabaseManager
{
    public mysqli $db;
    public function __construct()
    {
        try {
            $this->db = new mysqli(
                DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT, DB_SOCKET
            );
        } catch (mysqli_sql_exception $e) {
            $eh = new ErrorHandler();
            if (ENV == DEV) {
                $eh->error('data', 'DatabaseManager', '__construct()', $e, '500');
            } else {
                $eh->error('data', 'DatabaseManager', '__construct()', '[' . $e->getSqlState() . '] ' . $e->getMessage(), '500');
            }
        }
    }
    public function getUserData($user): object|null
    {
        $user = $this->db->query(
            "SELECT * FROM `".DB_PREFIX."users` WHERE `user` = '".$user."';"
        );
        if ($user->num_rows != 0) {
            return $user->fetch_object();
        } else {
            return null;
        }
    }

    public function createUser($username, $password): bool
    {
        $tableSearch = $this->db->query(
            "SHOW TABLES LIKE '".DB_PREFIX."users';"
        );
        if ($tableSearch->num_rows == 0) {
            $this->db->query(
                "CREATE TABLE `".DB_NAME."`.`".DB_PREFIX."users` (
                    `id` INT NOT NULL AUTO_INCREMENT ,
                    `user` VARCHAR(8) NOT NULL ,
                    `pass` VARCHAR(64) NOT NULL ,
                    PRIMARY KEY (`id`))
                    ENGINE = InnoDB;"
            );
        }

        $existingUser = $this->db->query(
            "SELECT `user` FROM `".DB_PREFIX."users` WHERE `user` = '".$username."'"
        );

        if ($existingUser->num_rows == 0) {
            if ($this->db->query(
                "INSERT INTO `".DB_PREFIX."users` (`id`, `user`, `pass`)
                VALUES (NULL, '".$username."', '".$password."')"
            )) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function createVault(): bool
    {
        $tableSearch = $this->db->query("SHOW TABLES LIKE '".DB_PREFIX."vault'; ");
        if ($tableSearch->num_rows == 0) {
            $this->db->query(
                "CREATE TABLE `".DB_NAME."`.`".DB_PREFIX."vault` (
                    `id` INT NOT NULL AUTO_INCREMENT ,
                    `user` VARCHAR(8) NOT NULL ,
                    `data` BLOB NOT NULL ,
                    PRIMARY KEY (`id`)) ENGINE = InnoDB;"
            );
        }
        return true;
    }
}
