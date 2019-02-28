<?php

namespace AppBundle\Controller;

use AppBundle\Service\ImageService;
use AppBundle\Service\PostService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    private $postService;
    private $imageService;

    function __construct(PostService $postService,ImageService $imageService) {
        $this->postService = $postService;
        $this->imageService = $imageService;
    }

    /**
     * @Route("/{hello}/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $size = $this->postService->getAllPostsSize();
        $numPages = ceil($size / $this->postService::LIMIT_POSTS );
        $curPage = $request->get('page');
        $posts = $this->postService->getAllPosts($curPage);
        return $this->render('main.html.twig', [
            'posts' => $posts,
            'size' => $size,
            'numPages' => $numPages,
            'curPage' => $curPage,
            'here' => $request->getPathInfo()
        ]);
    }

    /**
     * @Route("/{hello}/{helo}")
     */
    public function image(Request $request){

        $file= $this->imageService->generateImf($request->attributes->get('browser'));

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->setStatusCode(200);
        $response->setContent($file);
        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }

}
