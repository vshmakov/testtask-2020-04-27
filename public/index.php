<?php

require_once(__dir__ . '/../vendor/autoload.php');

use App\MainController;

$controller = new MainController();
$controller->homepage();
