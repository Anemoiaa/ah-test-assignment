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

}
