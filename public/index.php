<?php

declare(strict_types=1);

const PROJECT_DIRECTORY = __DIR__.'/..';

require_once PROJECT_DIRECTORY.'/vendor/autoload.php';

use App\MainController;
use App\SecurityManager;
use App\UserRepository;

$securityManager = new SecurityManager();
$connection = new Mysqli(
    'db:3306',
    $_ENV['MYSQL_USER'],
    $_ENV['MYSQL_PASSWORD'],
    $_ENV['MYSQL_DATABASE']
);
$userRepository = new UserRepository($connection);
$controller = new MainController($securityManager, $userRepository);
$handler = $controller->getHandler($_SERVER['REQUEST_URI']);
$handler();
