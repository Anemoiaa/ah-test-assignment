<?php

namespace Anemoiaa\AhTestAssignment\core;

use Anemoiaa\AhTestAssignment\controllers\HomeController;
use RuntimeException;
use Smarty\Smarty;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    private Smarty $view;

    public function __construct(Smarty $view)
    {
        $this->view = $view;
    }

    public function get(string $uri, array $action): void
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, array $action): void
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = trim($uri, '/');

        foreach ($this->routes[$method] as $path => $action) {
            $pattern = preg_replace('#\{(\w+)\}#', '(?P<$1>\d+)', $path);

            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                [$controller, $methodName] = $action;

                if (!class_exists($controller)) {
                    throw new RuntimeException("Controller {$controller} not found");
                }

                $controllerInstance = new $controller($this->view);

                if (!method_exists($controllerInstance, $methodName)) {
                    $controllerInstance->errorPage(404, "Method {$methodName} not found");
                    return;
                }

                call_user_func_array([$controllerInstance, $methodName], $params);
                return;
            }
        }

        $defaultController = new Controller($this->view);
        $defaultController->notFoundPage();
    }
}
