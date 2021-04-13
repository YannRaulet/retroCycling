<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminFrontController extends AbstractController
{
    /**
     * @Route(name="home")
     */
    public function home(): Response
    {
        return $this->render('admin/home.html.twig');
    }

     /**
     * @Route("/collection", name="collection")
     */
    public function collection(): Response
    {
        return $this->render('admin/collection.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog(): Response
    {
        return $this->render('admin/blog.html.twig');
    }

     /**
     * @Route("/article", name="article")
     */
    public function article(): Response
    {
        return $this->render('admin/article.html.twig');
    }

    /**
     * @Route("/gestion-de-contenu", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
