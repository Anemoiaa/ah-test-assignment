<?php

namespace Anemoiaa\AhTestAssignment\controllers;

use Anemoiaa\AhTestAssignment\core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view->display('home.tpl');
    }
}
