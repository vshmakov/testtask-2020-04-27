<?php

declare(strict_types=1);

namespace App;

final class SecurityManager
{
    public function isUserAuthenticated(): bool
    {
        return false;
    }
}
