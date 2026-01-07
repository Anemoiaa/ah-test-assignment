<?php

namespace Anemoiaa\AhTestAssignment\controllers;

use Anemoiaa\AhTestAssignment\core\Controller;
use Anemoiaa\AhTestAssignment\repositories\CategoryRepository;
use Smarty\Smarty;

class HomeController extends Controller
{
    private CategoryRepository $categoryRepo;

    public function __construct(Smarty $view)
    {
        parent::__construct($view);
        $this->categoryRepo = new CategoryRepository();
    }

    public function index(): void
    {
        $template = 'home.tpl';
        $cacheLifetime = 300;

        $this->view->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
        $this->view->setCacheLifetime($cacheLifetime);

        if ($this->view->isCached($template)) {
            $this->render($template);
            return;
        }

        $data = $this->categoryRepo->withLastPosts(3);
        $grouped = [];

        foreach ($data as $item) {
            $categoryName = $item['category_name'];

            if (!isset($grouped[$categoryName])) {
                $grouped[$categoryName] = [
                    'id'    => $item['category_id'],
                    'name'  => $item['category_name'],
                    'posts' => [],
                ];
            }

            $grouped[$categoryName]['posts'][] = [
                'id'          => $item['post_id'],
                'title'       => $item['title'],
                'description' => $item['description'],
                'image'       => $item['image'],
                'views'       => $item['views'],
                'created_at'  => $item['created_at'],
            ];
        }

        $this->render($template, [
            'categories' => $grouped,
        ]);
    }
}
