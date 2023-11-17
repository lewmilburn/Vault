<?php

namespace Vault\event;

class ExtensionHandler {
    public function vaultStartup(): void
    {
        $this->sodium();
        $this->mysqli();
        $this->json();
    }

    private function sodium(): void
    {
        if (!extension_loaded('sodium')) {
            $this->throwError('Sodium', 'Encrypt and decrypt data');
        }
    }

    private function mysqli(): void
    {
        if (!extension_loaded('mysqli')) {
            $this->throwError('MySQLi', 'Connect to the database');
        }
    }

    private function json(): void
    {
        if (!extension_loaded('json')) {
            $this->throwError('JSON', 'Store user and vault data');
        }
    }

    private function throwError(string $extension, string $reason): void
    {
        $eh = new ErrorHandler();
        $eh->error(
            'event',
            'ExtensionHandler',
            'throwError',
            '
            The PHP extension "'.$extension.'" is not installed.
            Vault requires this extension to '.$reason.'.
            Please check your php.ini file to ensure it\'s installed.
            ',
            '503'
        );
    }
}
