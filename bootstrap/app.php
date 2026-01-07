<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

set_exception_handler(function (Throwable $e) {
    error_log($e);

    http_response_code(500);

    if ($_ENV['APP_ENV'] === 'production') {
        require __DIR__ . '/../resources/views/errors/500.php';
    } else {
        echo '<pre>' . $e . '</pre>';
    }
});