<?php

namespace Vault\event;

class routeHandler
{
    public function getRequest($url, $file): void
    {
        if ($_SERVER['REQUEST_URI'] === $url && $_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->displayFile($file);
        }
    }

    public function endRouter(): void
    {
        $eh = new errorHandler();
        $eh->fileNotFound('event', 'routeHandler', 'endRouter');
    }

    private function displayFile($file): void
    {
        if (file_exists(__DIR__.'/../'.$file)) {
            require_once __DIR__.'/../'.$file;
        } else {
            $eh = new errorHandler();
            $eh->fileNotFound('event', 'routeHandler', 'displayFile');
        }
        exit;
    }
}
