<?php

namespace App\Controller;

use App\Entity\CyclingShirt;
use App\Form\CyclingShirtType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CyclingShirtRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\BackgroundPictureRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="admin_")
 * This controller is used to manage the CyclingShirt entity
 */
class AdminCyclingShirtController extends AbstractController
{
    /**
     * @Route("/maillots", name="cycling_shirts", methods={"GET"})
     * Display the page with the all cycling shirts
     * @return Response
     */
    public function cyclingShirts(
        CyclingShirtRepository $shirtRepository,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        return $this->render('admin/cycling_shirts.html.twig', [
            'cycling_shirts' => $shirtRepository->findAll(),
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/maillot/ajouter", name="cycling_shirt_new", methods={"GET","POST"})
     * Display the page for add a cycling shirt
     * @return Response
     */
    public function newCyclingShirt(
        Request $request,
        EntityManagerInterface $manager,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        $cyclingShirt = new CyclingShirt();
        $form = $this->createForm(CyclingShirtType::class, $cyclingShirt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($cyclingShirt);
            $manager->flush();

            return $this->redirectToRoute('admin_cycling_shirts');
        }

        return $this->render('admin/cycling_shirt_new.html.twig', [
            'cycling_shirt' => $cyclingShirt,
            'form' => $form->createView(),
            'background_pictures' => $backgroundRepository->findByName('background-main'),
        ]);
    }

    /**
     * @Route("/maillot/{id}", name="cycling_shirt_show", methods={"GET"})
     * Displays the page view cycling shirt details
     * @return Response
     */
    public function showCyclingShirt(
        CyclingShirt $cyclingShirt,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        return $this->render('admin/cycling_shirt_show.html.twig', [
            'cycling_shirt' => $cyclingShirt,
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/maillot/modifier/{id}", name="cycling_shirt_edit", methods={"GET","POST"})
     * Display the page for edit a cycling shirt
     * @return Response
     */
    public function editCyclingShirt(
        Request $request,
        CyclingShirt $cyclingShirt,
        EntityManagerInterface $manager,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        $form = $this->createForm(CyclingShirtType::class, $cyclingShirt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($cyclingShirt);
            $manager->flush();

            return $this->redirectToRoute('admin_cycling_shirts');
        }

        return $this->render('admin/cycling_shirt_edit.html.twig', [
            'cycling_shirt' => $cyclingShirt,
            'form' => $form->createView(),
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/maillot/supprimer/{id}", name="cycling_shirt_delete", methods={"DELETE"})
     * Display the page for delete a cycling shirt
     * @return Response
     */
    public function deleteCyclingShirt(
        Request $request,
        CyclingShirt $cyclingShirt,
        EntityManagerInterface $manager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $cyclingShirt->getId(), $request->request->get('_token'))) {
            $manager->remove($cyclingShirt);
            $manager->flush();
        }

        return $this->redirectToRoute('admin_cycling_shirts');
    }
}
