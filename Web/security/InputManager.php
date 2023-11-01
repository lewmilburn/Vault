<?php

namespace Vault\security;

class InputManager
{
    public function escapeString($string): string
    {
        return htmlspecialchars($string);
    }
}
