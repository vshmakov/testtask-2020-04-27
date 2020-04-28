<?php

declare(strict_types=1);

namespace App;

final class SecurityManager
{
    private const  USER_KEY = 'user';

    public function isUserAuthenticated(): bool
    {
        return \array_key_exists(self::USER_KEY, $_SESSION ?? []);
    }

    public function authenticate(string $username): void
    {
        session_start();
        $_SESSION[self::USER_KEY] = $username;
    }
}
