<?php

namespace App\Controller;

use App\Entity\CyclingShirt;
use App\Form\EditProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\BackgroundPictureRepository;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * display user profile information
     * @Route("/profil", name="profil")
     * @return Response
     */
    public function profil(BackgroundPictureRepository $backgroundRepository): Response
    {
        return $this->render('user/profil.html.twig', [
            'background_pictures' => $backgroundRepository->findByName('background-main'),
        ]);
    }

    /**
     * This method allows you to modify the user profile
     * @Route("/profil/modifier", name="edit_profil")
     * @return Response
     */
    public function editProfil(
        Request $request,
        EntityManagerInterface $manager,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        /** @phpstan-ignore-next-line */
        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @phpstan-ignore-next-line */
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Profil mis à jour!');
            return $this->redirectToRoute('user_profil');
        }

        return $this->render('user/edit_profil.html.twig', [
            'form' => $form->createView(),
            'background_pictures' => $backgroundRepository->findByName('background-main'),
        ]);
    }

    /**
     * This method allows you to modify the password in the user profile.
     * @Route("/pass/modifier", name="edit_password")
     * @return Response
     */
    public function editPassword(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $manager,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        if ($request->isMethod('POST')) {
            $user = $this->getUser();
            // On vérifie si les 2 mots de passe sont identiques
            if ($request->request->get('pass') == $request->request->get('pass2')) {
                /** @phpstan-ignore-next-line */
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                /** @phpstan-ignore-next-line */
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('user_profil');
            } else {
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('user/edit_password.html.twig', [
            'background_pictures' => $backgroundRepository->findByName('background-main'),
        ]);
    }

    /**
     * This method allows you show the favorites cycling shirts
     * @Route("/collection/{id}/like", name="favorite", methods={"GET", "POST"})
     * @return Response
     */
    public function addToFavorite(
        CyclingShirt $favorite,
        EntityManagerInterface $manager
    ): Response {
        if (!$this->getUser()->isInFavorite($favorite)) {
            $this->getUser()->addLike($favorite);
        } else {
            $this->getUser()->removeLike($favorite);
        }
        $manager->flush();

        return $this->json(['isInFavorite' => $this->getUser()->isInFavorite($favorite),
        ]);
    }
}
