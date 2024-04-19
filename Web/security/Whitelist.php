<?php

namespace Vault\security;

class Whitelist {
    public function check(string $ip): bool
    {
        if (WHITELIST !== false) {
            return in_array($ip, explode(',', WHITELIST));
        } else {
            return true;
        }
    }
}
