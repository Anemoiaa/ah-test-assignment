<?php

namespace Anemoiaa\AhTestAssignment\core;

use Smarty\Smarty;

class Controller
{
    protected Smarty $view;

    public function __construct(Smarty $view)
    {
        $this->view = $view;
    }

    protected function render(string $template, array $params = []): void
    {
        foreach ($params as $key => $value) {
            $this->view->assign($key, $value);
        }

        $this->view->display($template);
    }

    public function notFoundPage(string $message = 'Not found'): void
    {
        $this->errorPage('errors/404.tpl', 404, $message);
    }

    protected function errorPage(string $template, int $code, string $message): void
    {
        http_response_code($code);
        $this->render($template, [
            'code'    => $code,
            'message' => $message,
        ]);
    }
}
