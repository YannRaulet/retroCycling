<?php

namespace App\Controller;

use App\Entity\BackgroundImage;
use App\Form\BackgroundImageType;
use App\Repository\BackgroundImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
* @Route("/admin", name="admin_")
* This controller is used to manage the Background Image entity
*/
class AdminBackgroundImageController extends AbstractController
{
    /**
     * @Route("/images", name="background_images", methods={"GET"})
     * Display the page with all the background images
     * @return Response
     */
    public function backgroundImages(BackgroundImageRepository $backgroundRepository): Response
    {
        return $this->render('admin/background_images.html.twig', [
            'background_images' => $backgroundRepository->findAll(),
        ]);
    }

    /**
     * @Route("image/ajouter", name="background_image_new", methods={"GET","POST"})
     * Display the page that adds a background image
     */
    public function newBackgroundImage(Request $request): Response
    {
        $backgroundImage = new BackgroundImage();
        $form = $this->createForm(BackgroundImageType::class, $backgroundImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($backgroundImage);
            $entityManager->flush();

            return $this->redirectToRoute('admin_background_images');
        }

        return $this->render('admin/background_image_new.html.twig', [
            'background_image' => $backgroundImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/image/{id}", name="background_image_show", methods={"GET"})
     * Display the page that show a background image
     */
    public function showBackgroundImage(BackgroundImage $backgroundImage): Response
    {
        return $this->render('admin/background_image_show.html.twig', [
            'background_image' => $backgroundImage,
        ]);
    }

    /**
     * @Route("/image/modifier/{id}", name="background_image_edit", methods={"GET","POST"})
     * Display the page that edit a background image
     */
    public function editBackgroundImage(Request $request, BackgroundImage $backgroundImage): Response
    {
        $form = $this->createForm(BackgroundImageType::class, $backgroundImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_background_images');
        }

        return $this->render('admin/background_image_edit.html.twig', [
            'background_image' => $backgroundImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/image/supprimer/{id}", name="background_image_delete", methods={"DELETE"})
     * Display the page that delete a background image
     */
    public function deleteBackgroundImage(Request $request, BackgroundImage $backgroundImage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $backgroundImage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($backgroundImage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_background_images');
    }
}
