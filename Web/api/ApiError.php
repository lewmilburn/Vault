<?php

namespace Vault\api;

use JetBrains\PhpStorm\NoReturn;
use Vault\event\ErrorHandler;

class ApiError {
    private ErrorHandler $errorHandler;

    public function __construct() {
        $this->errorHandler = new ErrorHandler;
    }
    #[NoReturn]
    function dataNotRecieved(): void
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
    function missingData(): void
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
    function internalServerError(): void
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
    function unauthorised(): void
    {
        $this->errorHandler->unauthorised();
    }
}
