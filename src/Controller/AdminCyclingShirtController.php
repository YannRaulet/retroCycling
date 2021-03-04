<?php

namespace App\Controller;

use App\Entity\CyclingShirt;
use App\Form\CyclingShirtType;
use App\Repository\CyclingShirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/admin", name="admin_")
 */
class AdminCyclingShirtController extends AbstractController
{
    /**
     * @Route("/maillots", name="cycling_shirts", methods={"GET"})
     */
    public function cyclingShirts(CyclingShirtRepository $shirtRepository): Response
    {
        return $this->render('admin/cycling_shirts.html.twig', [
            'cycling_shirts' => $shirtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/maillot/ajouter", name="cycling_shirt_new", methods={"GET","POST"})
     */
    public function newCyclingShirt(Request $request, EntityManagerInterface $manager): Response
    {
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
        ]);
    }

    /**
     * @Route("/maillot/{id}", name="cycling_shirt_show", methods={"GET"})
     */
    public function showCyclingShirt(CyclingShirt $cyclingShirt): Response
    {
        return $this->render('admin/cycling_shirt_show.html.twig', [
            'cycling_shirt' => $cyclingShirt,
        ]);
    }

    /**
     * @Route("/maillot/modifier/{id}", name="cycling_shirt_edit", methods={"GET","POST"})
     */
    public function editCyclingShirt(
        Request $request,
        CyclingShirt $cyclingShirt,
        EntityManagerInterface $manager
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
        ]);
    }

    /**
     * @Route("/maillot/supprimer/{id}", name="cycling_shirt_delete", methods={"DELETE"})
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
