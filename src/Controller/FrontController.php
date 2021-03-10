<?php

namespace App\Controller;

use App\Entity\CyclingShirt;
use App\Repository\CyclingShirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticleRepository;
use App\Repository\ArticleContentRepository;

/**
 * Creates views that allow users to see the different produc
 * @Route(name="front_")
 */
class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('front/home.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     * This controler takes all articles and posters in the blog
     * @return Response
     */
    public function blog(ArticleRepository $articleRepository): Response
    {
        return $this->render('front/blog.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/article/{id<^[0-9]+$>}", name="article")
     * This controller displays a blog article and all its content
     * @return Response
     */
    public function article(
        ArticleRepository $articleRepository,
        ArticleContentRepository $contentRepository,
        int $id
    ): Response {
        return $this->render('front/article.html.twig', [
            'article' => $articleRepository->findOneBy(
                ['id' => $id]
            ),
            'articleContents' => $contentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('front/contact.html.twig');
    }
}
