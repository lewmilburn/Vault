<?php

namespace Vault\api\password;

use Vault\data\DataManager;
use Vault\security\HashManager;

class PasswordAPI
{
    private string $endHeaders = 'Location: /';

    public function create(): void
    {
        $hm = new HashManager();

        $dm = new DataManager();
        $dm->addPassword(
            $_SESSION['user'],
            $_SESSION['key'],
            $hm->generateUniqueId(),
            $_POST['user'],
            $_POST['pass'],
            $_POST['name'],
            $_POST['url'],
            $_POST['notes']
        );

        header($this->endHeaders);
        exit;
    }

    public function update(): void
    {
        $dm = new DataManager();
        $dm->updatePassword(
            $_SESSION['user'],
            $_SESSION['key'],
            $_POST['pid'],
            $_POST['user'],
            $_POST['pass'],
            $_POST['name'],
            $_POST['url'],
            $_POST['notes']
        );

        header($this->endHeaders);
        exit;
    }

    public function delete(): void
    {
        $dm = new DataManager();
        $dm->deletePassword(
            $_SESSION['user'],
            $_SESSION['key'],
            $_POST['pid'],
        );

        header($this->endHeaders);
        exit;
    }
}
