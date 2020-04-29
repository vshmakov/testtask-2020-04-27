<?php

declare(strict_types=1);

const PROJECT_DIRECTORY = __DIR__.'/..';

require_once PROJECT_DIRECTORY.'/vendor/autoload.php';

use App\MainController;

$securityManager = new \App\SecurityManager();
$controller = new MainController($securityManager);
$handler = $controller->getHandler($_SERVER['REQUEST_URI']);
$handler();
