<?php

namespace Vault\event;

class routeHandler
{
    public function getRequest() {

    }

    public function displayFile($file) {
        if (file_exists(__DIR__ . $file)) {
            require_once __DIR__ . $file;
        } else {
            $eh = new errorHandler();
            $eh->fileNotFound('event','routeHandler','displayFile');
        }
    }
}