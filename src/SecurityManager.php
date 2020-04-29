<?php

declare(strict_types=1);

namespace App;

final class SecurityManager
{
    private const  USER_KEY = 'user';

    public function unauthenticate(): void
    {
        session_start();

        if (\array_key_exists(self::USER_KEY, $_SESSION)) {
            unset($_SESSION[self::USER_KEY]);
        }

        session_write_close();
    }

    public function authenticate(string $username): void
    {
        session_start();
        $_SESSION[self::USER_KEY] = $username;
        session_write_close();
    }

    public function getUsername(): ?string
    {
        session_start();
        $username = $_SESSION[self::USER_KEY] ?? null;
        session_write_close();

        return $username;
    }
}
