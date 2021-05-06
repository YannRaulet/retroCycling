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
use App\Repository\BackgroundPictureRepository;
use Swift_Message;
use Exception;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(
        AuthenticationUtils $authenticationUtils,
        UserRepository $userRepository,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        // check if there is no user in database and redirects to initial user creation form
        if (empty($userRepository->findAll())) {
            return $this->redirectToRoute('app_registrer');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'background_pictures' => $backgroundRepository->findByName('background-connexion')
        ]);
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
        \Swift_Mailer $mailer,
        BackgroundPictureRepository $backgroundRepository
    ): ?Response {

        // 1) build the form
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user, array(
            // Time protection
            'antispam_time'     => true,
            'antispam_time_min' => 10,
            'antispam_time_max' => 80,
            // Honeypot protection
            'antispam_honeypot'       => true,
            'antispam_honeypot_class' => 'hide-me',
            'antispam_honeypot_field' => 'email-repeat',
        ));

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // We generate the activation token and encrypt the chain with a unique ID
            $user->setActivationToken($tokenGenerator->generateToken());

            if ($user->getEmail() == 'retrocyclingcontact@gmail.com') {
                $user->setRoles(['ROLE_ADMIN']);
            }
            // 4) save the User!
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('message', 'Un email vous a éte envoyé');

            // Create the account activation message
            $message = (new Swift_Message('Activation de votre compte'))
                ->setFrom('retrocyclingcontact@gmail.com')
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
                'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * This method will activate the user's account
     * @Route("/activation/{token}", name="activation")
     * @return Response
     */
    public function activation(string $token, UserRepository $userRepo, EntityManagerInterface $manager): Response
    {
        // Check if the user has a token
        $user = $userRepo->findOneBy(['activationToken' => $token]);
        // Check if it's the same token
        /** @phpstan-ignore-next-line */
        $tokenExist = $user->getActivationToken();
        if ($token === $tokenExist) {
            // Delete the token
            /** @phpstan-ignore-next-line */
            $user->setActivationToken(null);
            /** @phpstan-ignore-next-line */
            $user->setEnabled(true);
            /** @phpstan-ignore-next-line */
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Votre compte est activé, vous pouvez dès maintenant vous connecter');
            return $this->redirectToRoute('front_home');
        } else {
            // If no user is associated with this token, an error message is displayed
            return $this->redirectToRoute('front_home');
        }
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
        // We initialize the form
        $form = $this->createForm(ResetPassType::class);

        // We process the form
        $form->handleRequest($request);

        // If the form is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // We recover the data
            $donnees = $form->getData();

            // We are looking for a user with this e-mail
            $user = $userRepository->findOneByEmail($donnees['email']);

            // If the user does not exist
            if (!$user) {
                // We send an alert saying that the e-mail address is unknown
                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');
                // We return to the login page
                return $this->redirectToRoute('app_login');
            }

            // We generate a token
            $token = $tokenGenerator->generateToken();

            // We write the token in the database
            try {
                $user->setResetToken($token);
                $manager->persist($user);
                $manager->flush();
            } catch (Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('app_login');
            }

            // We generate the forgotten password email
            $message = (new Swift_Message('Mot de passe oublié'))
                ->setFrom('retrocyclingcontact@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/forgotten_pass.html.twig',
                        ['token' => $user->getResetToken()]
                    ),
                    'text/html'
                );

            // We send the email
            $mailer->send($message);

            // We create the confirmation flash message
            $this->addFlash('message', 'E-mail de réinitialisation du mot de passe envoyé !');

            // We redirect to the login page
            return $this->redirectToRoute('app_login');
        }

        // We send the form to the view
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
        // We are looking for a user with the given token
        $user = $userRepository->findOneBy([
            'resetToken' => $token
        ]);

        // If the user does not exist
        if (!$user) {
            // We display an error
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('app_login');
        }

        // If the form is sent by POST method
        if ($request->isMethod('POST')) {
            // We delete token
            $user->setResetToken(null);

            // We encrypt the password
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

            // We store it in the entity
            $manager->persist($user);
            $manager->flush();

            // We create the flash message
            $this->addFlash('success', 'Mot de passe mis à jour');

            return $this->redirectToRoute('front_home');
        } else {
            // If we have not received the data, we display the form
            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }
    }
}
