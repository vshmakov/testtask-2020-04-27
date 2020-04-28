<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use App\MainController;

$securityManager = new \App\SecurityManager();
$controller = new MainController($securityManager);
$handler = $controller->getHandler($_SERVER['REQUEST_URI']);
$handler();
