<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function profil(): Response
    {
        return $this->render('user/profil.html.twig');
    }

    /**
     * @Route("/profil/modifier", name="edit_profil")
     */
    public function editProfil(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Profil mis à jour!');
            return $this->redirectToRoute('user_profil');
        }

        return $this->render('user/edit_profil.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/pass/modifier", name="edit_password")
     */
    public function editPassword(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $manager
    ): Response {
        if ($request->isMethod('POST')) {
            $user = $this->getUser();
            // On vérifie si les 2 mots de passe sont identiques
            if ($request->request->get('pass') == $request->request->get('pass2')) {
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('user_profil');
            } else {
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('user/edit_password.html.twig');
    }
}
