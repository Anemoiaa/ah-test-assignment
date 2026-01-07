<?php

namespace Anemoiaa\AhTestAssignment\core;

use Smarty\Smarty;

class Application
{
    private Router $router;
    private Smarty $view;

    public function __construct()
    {
        $this->view = $this->initSmarty();
        $this->router = new Router($this->view);
    }

    public function router(): Router
    {
        return $this->router;
    }

    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $this->router->dispatch($method, $uri);
    }

    private function initSmarty(): Smarty
    {
        $smarty = new Smarty();
        $smarty->setTemplateDir(__DIR__ . '/../../resources/views');
        $smarty->setCompileDir(__DIR__ . '/../../storage/compile');
        $smarty->setCacheDir(__DIR__ . '/../../storage/cache');

        $smarty->setEscapeHtml(true);

        return $smarty;
    }
}
