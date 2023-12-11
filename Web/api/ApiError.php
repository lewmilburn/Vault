<?php

namespace Vault\api;

use JetBrains\PhpStorm\NoReturn;
use Vault\event\ErrorHandler;

class ApiError
{
    private ErrorHandler $errorHandler;

    public function __construct()
    {
        $this->errorHandler = new ErrorHandler();
    }

    #[NoReturn]
    public function dataNotRecieved(): void
    {
        $this->errorHandler->error(
            'api',
            'ApiError',
            'dataNotRecieved',
            'Required data not recieved.',
            400
        );
    }

    #[NoReturn]
    public function missingData(): void
    {
        $this->errorHandler->error(
            'api',
            'ApiError',
            'missingData',
            'Missing required data..',
            400
        );
    }

    #[NoReturn]
    public function internalServerError(): void
    {
        $this->errorHandler->error(
            'api',
            'ApiError',
            'dataNotRecieved',
            'Internal server error.',
            500
        );
    }

    #[NoReturn]
    public function unauthorised(): void
    {
        $this->errorHandler->unauthorised();
    }

    #[NoReturn]
    public function alreadyAuthenticated(): void
    {
        $this->errorHandler->error(
            'api',
            'ApiError',
            'alreadyAuthenticated',
            'Already authenticated.',
            400
        );
    }

    public function notesNull($notes): string|null
    {
        if (!isset($notes)) {
            return null;
        } else {
            return $notes;
        }
    }
}
