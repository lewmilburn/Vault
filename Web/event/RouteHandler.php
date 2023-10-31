<?php

namespace Vault\event;

use JetBrains\PhpStorm\NoReturn;

class RouteHandler
{
    #[NoReturn]
    public function getRequest($url, $file): void
    {
        $this->request($url, $file, 'GET');
    }

    #[NoReturn]
    public function postRequest(string $url, string $file): void
    {
        $this->request($url, $file, 'POST');
    }

    #[NoReturn]
    public function request(string $url, string $file, string $method): void
    {
        if ($_SERVER['REQUEST_URI'] === $url && $_SERVER['REQUEST_METHOD'] === $method) {
            $this->runFile($file);
        }
    }

    #[NoReturn]
    public function endRouter(): void
    {
        $eh = new ErrorHandler();
        $eh->fileNotFound('event', 'routeHandler', 'endRouter');
    }

    #[NoReturn]
    private function runFile($file): void
    {
        if (file_exists(__DIR__.'/../'.$file)) {
            require_once __DIR__.'/../'.$file;
        } else {
            $eh = new ErrorHandler();
            $eh->fileNotFound('event', 'routeHandler', 'displayFile');
        }
        exit;
    }
}