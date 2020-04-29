<?php

declare(strict_types=1);

namespace App;

final class SecurityManager
{
    private const  USER_KEY = 'user';

    public function __construct()
    {
        session_start();
    }

    public function isUserAuthenticated(): bool
    {
        return null !== $this->getUsername();
    }

    public function unauthenticate(): void
    {
        if (\array_key_exists(self::USER_KEY, $_SESSION)) {
            unset($_SESSION[self::USER_KEY]);
        }
    }

    public function authenticate(string $username): void
    {
        $_SESSION[self::USER_KEY] = $username;
    }

    public function getUsername(): ?string
    {
        return $_SESSION[self::USER_KEY] ?? null;
    }
}
