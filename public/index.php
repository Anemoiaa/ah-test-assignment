<?php

require_once __DIR__ . '/../bootstrap/app.php';

use Anemoiaa\AhTestAssignment\controllers\HomeController;
use Anemoiaa\AhTestAssignment\core\Application;

$app = new Application();

$app->router()->get('', [HomeController::class, 'index']);

$app->run();