<?php

namespace Vault;

class InputManager
{
    public function escapeString($string): string
    {
        return htmlspecialchars($string);
    }
}
