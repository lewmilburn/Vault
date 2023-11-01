<?php

namespace Vault\security;

class InputManager
{
    /**
     * Escapes a string
     * @param string $string
     * @return string
     */
    public function escapeString(string $string): string
    {
        return htmlspecialchars($string);
    }
}
