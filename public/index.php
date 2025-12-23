<?php

use App\Core\App;

// Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Application
$app = App::getInstance();
$app->run();
