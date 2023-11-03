<?php

namespace Vault\security;

class InputManager
{
    /**
     * Escapes a string.
     *
     * @param string $string
     *
     * @return string
     */
    public function escapeString(string $string): string
    {
        $string = trim($string);

        return htmlspecialchars($string);
    }

    /**
     * Strips slashes from a string.
     *
     * @param string $string
     *
     * @return string
     */
    public function stripSlashes(string $string): string
    {
        $string = trim($string);

        return stripslashes($string);
    }
}
