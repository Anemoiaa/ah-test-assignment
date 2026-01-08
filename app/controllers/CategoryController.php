<?php

namespace Anemoiaa\AhTestAssignment\controllers;

use Anemoiaa\AhTestAssignment\core\Controller;
use Anemoiaa\AhTestAssignment\repositories\CategoryRepository;
use Anemoiaa\AhTestAssignment\repositories\PostRepository;
use Smarty\Smarty;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepo;
    private PostRepository $postRepo;

    public function __construct(Smarty $view)
    {
        parent::__construct($view);
        $this->categoryRepo = new CategoryRepository();
        $this->postRepo = new PostRepository();
    }

    public function show(int $id): void
    {
        $template = 'category/show.tpl';
        $cacheLifetime = 300;

        $sort = $_GET['sort'] ?? 'newest';
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = 9;

        $this->view->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
        $this->view->setCacheLifetime($cacheLifetime);

        $cacheId = sprintf('category:%s-%s-%s-%s', $id, $sort, $page, $perPage);

        if ($this->view->isCached($template, $cacheId)) {
            $this->render($template, cacheId: $cacheId);
            return;
        }

        $category = $this->categoryRepo->findWithPostsCount($id);
        if (!$category) {
            $this->notFoundPage();
            return;
        }

        $postsResult = $this->postRepo->getPostsByCategory($id, $sort, $page, $perPage);
        $totalPages = (int) ceil($postsResult['total'] / $perPage);

        $this->render($template, [
            'category'    => $category,
            'posts'       => $postsResult['data'],
            'total'       => $category['posts_count'],
            'page'        => $page,
            'perPage'     => $perPage,
            'totalPages'  => $totalPages,
            'sortOptions' => PostRepository::SORT_OPTIONS,
            'currentSort' => $sort,
        ], $cacheId);
    }
}
