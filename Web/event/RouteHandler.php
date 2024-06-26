<?php

namespace Vault\event;

use JetBrains\PhpStorm\NoReturn;

class RouteHandler
{
    public function getRequest($url, $file): void
    {
        $this->request($url, $file, 'GET');
    }

    public function postRequest(string $url, string $file): void
    {
        $this->request($url, $file, 'POST');
    }

    public function putRequest(string $url, string $file): void
    {
        $this->request($url, $file, 'PUT');
    }

    public function deleteRequest(string $url, string $file): void
    {
        $this->request($url, $file, 'DELETE');
    }

    public function anyRequest(string $url, string $file)
    {
        $request = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
        if ($request == $url) {
            $this->runFile($file);
        }
    }

    public function request(string $url, string $file, string $method): void
    {
        $request = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
        if ($request == $url && $_SERVER['REQUEST_METHOD'] == $method) {
            $this->runFile($file);
        }
    }

    #[NoReturn]
    public function endRouter(): void
    {
        header('Location: /');
        exit;
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
