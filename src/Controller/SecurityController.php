<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Core\Exception\LogicException;
use App\Form\RegistrationFormType;
use App\Form\ResetPassType;
use App\Entity\User;
use App\Repository\UserRepository;
use Swift_Message;
use Exception;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository): Response
    {
        // check if there is no user in database and redirects to initial user creation form
        if (empty($userRepository->findAll())) {
            return $this->redirectToRoute('app_registrer');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new LogicException('This method can be blank -
        it will be intercepted by the logout key on your firewall.');
    }

    /**
     * This method will register a user and send an email
     * @Route("/inscription", name="app_registrer")
     * @return Response
     */
    public function register(
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordEncoderInterface $passwordEncoder,
        TokenGeneratorInterface $tokenGenerator,
        \Swift_Mailer $mailer
    ): ?Response {

        // 1) build the form
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //On génère le token d'activation et chiffre la chaine avec un ID unique
            $user->setActivationToken($tokenGenerator->generateToken());

            // 4) save the User!
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('message', 'Un email vous a éte envoyé');

            //Créer le message activation du compte
            $message = (new Swift_Message('Activation de votre compte'))
                ->setFrom('admin@monsite.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/activation.html.twig',
                        ['token' => $user->getActivationToken()]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/registrer.html.twig', [
                'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * This method will activate the user's account
     * @Route("/activation/{token}", name="activation")
     * @return Response
     */
    public function activation(string $token, UserRepository $userRepo, EntityManagerInterface $manager): Response
    {
        //Vérifie si l'utilisateur a un token
        $user = $userRepo->findOneBy(['activationToken' => $token]);

        //Si aucun utilisateur n'est associé à ce token
        if (!$user) {
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        //Supprime le token
        $user->setActivationToken(null);
        $manager->persist($user);
        $manager->flush();
        $this->addFlash('success', 'Vous avez bien activé votre compte');

        return $this->redirectToRoute('front_home');
    }

    /**
     * This method will make a password reset request
     * @Route("/oubli-mot-de-passe", name="app_forgotten_password")
     * @return Response
     */
    public function forgetPass(
        Request $request,
        UserRepository $userRepository,
        \Swift_Mailer $mailer,
        EntityManagerInterface $manager,
        TokenGeneratorInterface $tokenGenerator
    ): Response {
        // On initialise le formulaire
        $form = $this->createForm(ResetPassType::class);

        // On traite le formulaire
        $form->handleRequest($request);

        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données
            $donnees = $form->getData();

            // On cherche un utilisateur ayant cet e-mail
            $user = $userRepository->findOneByEmail($donnees['email']);

            // Si l'utilisateur n'existe pas
            if (!$user) {
                // On envoie une alerte disant que l'adresse e-mail est inconnue
                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');
                // On retourne sur la page de connexion
                return $this->redirectToRoute('app_login');
            }

            // On génère un token
            $token = $tokenGenerator->generateToken();

            // On écrit le token en base de données
            try {
                $user->setResetToken($token);
                $manager->persist($user);
                $manager->flush();
            } catch (Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('app_login');
            }

            // On génère l'e-mail du mot de passe oublié
            $message = (new Swift_Message('Mot de passe oublié'))
                ->setFrom('admin@monsite.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/forgotten_pass.html.twig',
                        ['token' => $user->getResetToken()]
                    ),
                    'text/html'
                );

            // On envoie l'e-mail
            $mailer->send($message);

            // On crée le message flash de confirmation
            $this->addFlash('message', 'E-mail de réinitialisation du mot de passe envoyé !');

            // On redirige vers la page de login
            return $this->redirectToRoute('app_login');
        }

        // On envoie le formulaire à la vue
        return $this->render('security/forgotten_password.html.twig', [
            'emailForm' => $form->createView()
        ]);
    }

    /**
     * This method will reset a new password
     * @Route("/reset_pass/{token}", name="app_reset_password")
     * @return Response
     */
    public function resetPassword(
        Request $request,
        string $token,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $userRepository,
        EntityManagerInterface $manager
    ): Response {
        // On cherche un utilisateur avec le token donné
        $user = $userRepository->findOneBy([
            'resetToken' => $token
        ]);

        // Si l'utilisateur n'existe pas
        if (!$user) {
            // On affiche une erreur
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('app_login');
        }

        // Si le formulaire est envoyé en méthode post
        if ($request->isMethod('POST')) {
            // On supprime le token
            $user->setResetToken(null);

            // On chiffre le mot de passe
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

            // On stocke dans l'entité
            $manager->persist($user);
            $manager->flush();

            // On crée le message flash
            $this->addFlash('message', 'Mot de passe mis à jour');

            return $this->redirectToRoute('app_login');
        } else {
            // Si on n'a pas reçu les données, on affiche le formulaire
            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }
    }
}
