<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\ArticleContentRepository;
use App\Repository\CyclingShirtRepository;

/**
 * Creates views that allow users to see the three last cycling shirts in each  category
 * @Route(name="front_")
 */
class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * Displays the page showing cycling shirts from each categories
     */
    public function homeCollection(CyclingShirtRepository $shirtRepository): Response
    {
        return $this->render('front/home.html.twig', [
            'cyclingShirts50_60' => $shirtRepository->findBy(
                ['years' => 'Années 50-60'],
                ['id' => 'DESC'],
                3
            ),
            'cyclingShirts70' => $shirtRepository->findBy(
                ['years' => 'Années 70'],
                ['id' => 'DESC'],
                3
            ),
            'cyclingShirts80' => $shirtRepository->findBy(
                ['years' => 'Années 80'],
                ['id' => 'DESC'],
                3
            ),
            'cyclingShirts90' => $shirtRepository->findBy(
                ['years' => 'Années 90'],
                ['id' => 'DESC'],
                3
            ),
        ]);
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
        int $id,
        Article $article
    ): Response {
        return $this->render('front/article.html.twig', [
            'article' => $articleRepository->findOneBy(
                ['id' => $id]
            ),
            'articleContents' => $contentRepository->findBy(['article' => $article]),
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
