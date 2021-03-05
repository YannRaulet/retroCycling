<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/admin", name="admin_")
 * This controller is used to manage the Category entity for Article entity
 */
class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/catégories", name="categories", methods={"GET"})
     * Display the page with the all categories
     * @return Response
     */
    public function categories(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/categories.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/catégorie/ajouter", name="category_new", methods={"GET","POST"})
     * Display the page for add a category
     * @return Response
     */
    public function newCategory(Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('admin/category_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/catégory/modifier/{id}/", name="category_edit", methods={"GET","POST"})
     * Display the page for edit a category
     * @return Response
     */
    public function editCategory(Request $request, Category $category, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('admin/category_edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/supprimer/{id}", name="category_delete", methods={"DELETE"})
     * Display the page for delete a category
     * @return Response
     */
    public function deleteCategory(Request $request, Category $category, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $manager->remove($category);
            $manager->flush();
        }

        return $this->redirectToRoute('admin_categories');
    }
}
