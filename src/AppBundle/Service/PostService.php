<?php

namespace AppBundle\Service;


use AppBundle\Repository\PostRepository;

class PostService
{
    const LIMIT_POSTS = 2;
    private $postRepository;

    function __construct(PostRepository $postRepository) {
        $this->postRepository=$postRepository;
    }

    public function getAllPosts($page = 0) {
        if ($page < 1 ) $page = 1;

        $offset = ($page - 1) * self::LIMIT_POSTS;

        return $this->postRepository->getAllPosts($offset, self::LIMIT_POSTS);
    }

    public function getAllPostsSize() {
        return $this->postRepository->getAllPostsSize();
    }
}