<?php

namespace Vault\event;

class ErrorHandler
{
    public function error(string|null $namespace, string|null $class, string|null $function, string $message, string $code): void
    {
        http_response_code($code);
        ob_end_clean();
        echo' <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Vault Error</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
            </head>
            <body class="p-4">
                <div class="text-center">
                    <img src="/assets/images/vault.png" alt="Vault" style="width:4rem">
                    <h1>Error '.$code.'</h1>
                </div>
                <table class="table">
                    <tr>
                        <th scope="row">Function</th>
                        <td>Vault\\'.$namespace.'\\'.$class.'::'.$function.'</td>
                    </tr>
                    <tr>
                        <th scope="row">Error</th>
                        <td>'.$message.'</td>
                    </tr>
                </table>
            </body>
        </html>';
        exit;
    }

    public function sessionRequired(string $namespace, string $class, string $function): void
    {
        $this->error($namespace, $class, $function, 'Internal Server Error - An active PHP session is required to run this function.', 500);
    }

    public function fileNotFound(string $namespace, string $class, string $function)
    {
        $this->error($namespace, $class, $function, 'File Not Found - The requested file could not be found.', 404);
    }
}
