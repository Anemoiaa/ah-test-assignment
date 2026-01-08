<?php

namespace Anemoiaa\AhTestAssignment\controllers;

use Anemoiaa\AhTestAssignment\core\Controller;
use Anemoiaa\AhTestAssignment\repositories\PostRepository;
use Smarty\Smarty;

class PostController extends Controller
{
    private PostRepository $postRepository;

    public function __construct(Smarty $view)
    {
        parent::__construct($view);
        $this->postRepository = new PostRepository();
    }

    public function show(int $id): void
    {
        $template = 'post/show.tpl';
        $cacheLifetime = 60;

        $cacheId = "post:$id";

        $this->view->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
        $this->view->setCacheLifetime($cacheLifetime);

        if ($this->view->isCached($template, $cacheId)) {
            $this->postRepository->incrementViews($id);
            $this->render($template, cacheId: $cacheId);
            return;
        }

        $post = $this->postRepository->find($id);
        if (!$post) {
            $this->notFoundPage();
            return;
        }

        $similarPosts = $this->postRepository->getSimilarPosts($post['id']);
        $this->postRepository->incrementViews($post['id']);

        $this->render('post/show.tpl', [
            'post'         => $post,
            'similarPosts' => $similarPosts,
        ], $cacheId);
    }
}
