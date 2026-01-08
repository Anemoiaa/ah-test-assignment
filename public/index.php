<?php

require_once __DIR__ . '/../bootstrap/app.php';

use Anemoiaa\AhTestAssignment\controllers\HomeController;
use Anemoiaa\AhTestAssignment\controllers\PostController;
use Anemoiaa\AhTestAssignment\core\Application;
use Anemoiaa\AhTestAssignment\controllers\CategoryController;

$app = new Application();

$app->router()->get('', [HomeController::class, 'index']);
$app->router()->get('categories/{id}', [CategoryController::class, 'show']);
$app->router()->get('posts/{id}', [PostController::class, 'show']);

$app->run();