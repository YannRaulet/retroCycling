<?php

namespace App\Controller;

use App\Entity\BackgroundPicture;
use App\Form\BackgroundPictureType;
use App\Repository\BackgroundPictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
* @Route("/admin", name="admin_")
* This controller is used to manage the Background Picture entity
*/
class AdminBackgroundPictureController extends AbstractController
{
    /**
     * @Route("/images", name="background_pictures", methods={"GET"})
     * Display the page with all the background pictures
     * @return Response
     */
    public function backgroundPictures(BackgroundPictureRepository $backgroundRepository): Response
    {
        return $this->render('admin/background_pictures.html.twig', [
            'background_pictures' => $backgroundRepository->findAll(),
        ]);
    }

    /**
     * @Route("image/ajouter", name="background_picture_new", methods={"GET","POST"})
     * Display the page that adds a background picture
     */
    public function newBackgroundPicture(Request $request): Response
    {
        $backgroundPicture = new BackgroundPicture();
        $form = $this->createForm(BackgroundPictureType::class, $backgroundPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($backgroundPicture);
            $entityManager->flush();

            return $this->redirectToRoute('admin_background_pictures');
        }

        return $this->render('admin/background_picture_new.html.twig', [
            'background_picture' => $backgroundPicture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/image/{id}", name="background_picture_show", methods={"GET"})
     * Display the page that show a background picture
     */
    public function showBackgroundPicture(BackgroundPicture $backgroundPicture): Response
    {
        return $this->render('admin/background_picture_show.html.twig', [
            'background_picture' => $backgroundPicture,
        ]);
    }

    /**
     * @Route("/image/modifier/{id}", name="background_picture_edit", methods={"GET","POST"})
     * Display the page that edit a background picture
     */
    public function edit(Request $request, BackgroundPicture $backgroundPicture): Response
    {
        $form = $this->createForm(BackgroundPictureType::class, $backgroundPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_background_pictures');
        }

        return $this->render('admin/background_picture_edit.html.twig', [
            'background_picture' => $backgroundPicture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/image/supprimer/{id}", name="background_picture_delete", methods={"DELETE"})
     * Display the page that delete a background picture
     */
    public function delete(Request $request, BackgroundPicture $backgroundPicture): Response
    {
        if ($this->isCsrfTokenValid('delete' . $backgroundPicture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($backgroundPicture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_background_pictures');
    }
}