<?php

namespace Vault;

class inputManager
{
    public function escapeString($string): string
    {
        return htmlspecialchars($string);
    }
}
