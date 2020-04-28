<?php

declare(strict_types=1);

namespace App;

final class MainController
{
    private SecurityManager $securityManager;

    public function __construct(SecurityManager $securityManager)
    {
        $this->securityManager = $securityManager;
    }

    public function getHandler(string $route): callable
    {
        switch ($route) {
            case  '/':
                return [$this, 'profile'];

                break;

            case  '/login':
                return [$this, 'login'];

                break;
        }
    }

    public function profile(): void
    {
        if (!$this->securityManager->isUserAuthenticated()) {
            $this->redirect('/login');

            return;
        }
    }

    public function login(): void
    {
        echo 'login';
    }

    private function redirect(string $route): void
    {
        header("location: $route");
    }
}
