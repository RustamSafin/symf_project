<?php

namespace AppBundle\Repository;


use Symfony\Component\HttpFoundation\File\File;

class PostRepository
{
    public function getAllPosts($offset, $limit) {
        $json = file_get_contents('../posts.json');
        $json = json_decode($json);
        return array_slice($json,$offset,$limit);
    }

    public function getAllPostsSize() {
        $json = file_get_contents('../posts.json');
        $json = json_decode($json);
        return count($json);
    }
}