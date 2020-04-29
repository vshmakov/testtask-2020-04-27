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

            default:
                return [$this, 'notFound'];

                break;
        }
    }

    public function profile(): void
    {
        if (!$this->securityManager->isUserAuthenticated()) {
            $this->redirect('/login');

            return;
        }

        $withdraw = 0;

        if ($this->isPostHttpMethod()) {
            $floatWithdraw = (float) ($_POST['withdraw'] ?? '0');
            $withdraw = (int) ($floatWithdraw * 100);

            if (0 < $withdraw) {
                $this->redirect('/');

                return;
            }
        }

        $this->render('profile.php', [
            'title' => 'Your profile',
            'amount' => 5000,
            'withdraw' => $withdraw,
        ]);
    }

    public function login(): void
    {
        if ($this->isPostHttpMethod()) {
            //some csrf protection here
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            if (null !== $username && null !== $password) {
                $this->securityManager->authenticate($username);
                $this->redirect('/');

                return;
            }
        }

        $this->render('login.php', [
            'title' => 'Login to site',
            'username' => $username ?? 'admin',
            'password' => $password ?? 123,
        ]);
    }

    public function notFound(): void
    {
        http_response_code(404);
        $this->render('notFound.php', [
            'title' => '404. Page not found',
        ]);
    }

    private function redirect(string $route): void
    {
        header("location: $route");
    }

    private function render(string $template, array $parameters): void
    {
        extract($parameters);

        foreach (['header.php', $template, 'footer.php'] as $part) {
            require_once sprintf('%s/templates/%s', PROJECT_DIRECTORY, $part);
        }
    }

    private function isPostHttpMethod(): bool
    {
        return 'POST' === $_SERVER['REQUEST_METHOD'];
    }
}
