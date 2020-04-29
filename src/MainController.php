<?php

declare(strict_types=1);

namespace App;

final class MainController
{
    private SecurityManager $securityManager;

    private UserRepository $userRepository;

    public function __construct(SecurityManager $securityManager, UserRepository $userRepository)
    {
        $this->securityManager = $securityManager;
        $this->userRepository = $userRepository;
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

            case  '/logout':
                return [$this, 'logout'];
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

        $username = $this->securityManager->getUsername();
        $amount = $this->userRepository->getAmount($username);
        $errors = [];
        $withdraw = 0;

        if ($this->isPostHttpMethod()) {
            //some csrf protection here
            $floatWithdraw = (float) ($_POST['withdraw'] ?? '0');
            $withdraw = (int) ($floatWithdraw * 100);

            if (0 >= $withdraw) {
                $errors[] = 'Withdraw is not valid';
            }

            if ($amount < $withdraw) {
                $errors[] = 'Withdraw must not be greater than account amount';
            }

            if (empty($errors)) {
                $this->userRepository->withdraw($username, $withdraw);
                $this->redirect('/');

                return;
            }
        }

        $this->render('profile.php', [
            'title' => 'Your profile',
            'errors' => $errors,
            'amount' => $amount / 100,
            'withdraw' => $withdraw / 100,
        ]);
    }

    public function logout(): void
    {
        $this->securityManager->unauthenticate();
        $this->redirect('/');
    }

    public function login(): void
    {
        if ($this->isPostHttpMethod()) {
            //some csrf protection here
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            if (
                null !== $username
                && null !== $password
                && $this->userRepository->userExists($username, $this->hashPassword($password))
            ) {
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

    private function hashPassword(string $password): string
    {
        return  crypt($password, 'some_salt');
    }
}
