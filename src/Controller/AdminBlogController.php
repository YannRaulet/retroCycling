<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Entity\ArticleContent;
use App\Form\ArticleContentType;
use App\Repository\ArticleContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/admin", name="admin_")
 * This controller is used to manage the Article and ArticleContent entity
 */
class AdminBlogController extends AbstractController
{
    /**
     * @Route("/articles", name="articles", methods={"GET"})
     * Display the page with the all articles
     * @return Response
     */
    public function articles(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin/articles.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/article/ajouter", name="article_new", methods={"GET","POST"})
     * Displays the page for add a new article
     * @return Response
     */
    public function newArticle(Request $request, EntityManagerInterface $manager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('admin/article_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show", methods={"GET"})
     * Displays the page view article details
     * @return Response
     */
    public function showArticle(Article $article): Response
    {
        return $this->render('/admin/article_show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/article/modifier/{id}", name="article_edit", methods={"GET","POST"})
     * Displays the page view for edit an article
     * @return Response
     */
    public function editArticle(Request $request, Article $article, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('admin/article_edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/supprimer/{id}", name="article_delete", methods={"DELETE"})
     * Displays the page view for delete an article
     * @return Response
     */
    public function deleteArticle(Request $request, Article $article, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $manager->remove($article);
            $manager->flush();
        }

        return $this->redirectToRoute('admin_articles');
    }

    /**
     * @Route("/contenus", name="contents", methods={"GET"})
     * Displays the page with the all contents article
     * @return Response
     */
    public function contents(ArticleContentRepository $contentRepository): Response
    {
        return $this->render('admin/contents.html.twig', [
            'article_contents' => $contentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/contenu/ajouter", name="content_new", methods={"GET","POST"})
     * Displays the page for create a content
     * @return Response
     */
    public function newContent(Request $request, EntityManagerInterface $manager): Response
    {
        $articleContent = new ArticleContent();
        $form = $this->createForm(ArticleContentType::class, $articleContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($articleContent);
            $manager->flush();

            return $this->redirectToRoute('admin_contents');
        }

        return $this->render('admin/content_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contenu/{id}", name="content_show", methods={"GET"})
     * Displays the page view content details
     * @return Response
     */
    public function showContent(ArticleContent $articleContent): Response
    {
        return $this->render('admin/content_show.html.twig', [
            'article_content' => $articleContent,
        ]);
    }

    /**
     * @Route("/contenu/modifier/{id}", name="content_edit", methods={"GET","POST"})
     * Displays the page view for edit a content
     * @return Response
     */
    public function editContent(
        Request $request,
        ArticleContent $articleContent,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(ArticleContentType::class, $articleContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($articleContent);
            $manager->flush();

            return $this->redirectToRoute('admin_contents');
        }

        return $this->render('admin/content_edit.html.twig', [
            'article_content' => $articleContent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contenu/supprimer/{id}", name="content_delete", methods={"DELETE"})
     * Displays the page view for delete a content article
     * @return Response
     */
    public function deleteContent(
        Request $request,
        ArticleContent $articleContent,
        EntityManagerInterface $manager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $articleContent->getId(), $request->request->get('_token'))) {
            $manager->remove($articleContent);
            $manager->flush();
        }

        return $this->redirectToRoute('admin_contents');
    }
}
