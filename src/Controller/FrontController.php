<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/collection", name="collection")
     */
    public function collection(): Response
    {
        return $this->render('front/collection.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog(): Response
    {
        return $this->render('front/blog.html.twig');
    }

     /**
     * @Route("/article", name="article")
     */
    public function article(): Response
    {
        return $this->render('front/article.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('front/contact.html.twig');
    }
}
