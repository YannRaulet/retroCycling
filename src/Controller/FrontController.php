<?php

namespace App\Controller;

use Swift_Message;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CyclingShirtRepository;
use App\Repository\BackgroundPictureRepository;
use App\Repository\ArticleContentRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DateTime;

/**
 * Creates views showing the three last cycling shirts for each category
 * @Route(name="front_")
 */
class FrontController extends AbstractController
{
    /**
     * Displays contact page
     * @Route("/contact", name="contact_us")
     * @return Response
     */
    public function contactUs(
        Request $request,
        \Swift_Mailer $mailer,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        $form = $this->createForm(ContactType::class, null, array(
            // Time protection
            'antispam_time'     => true,
            'antispam_time_min' => 10,
            'antispam_time_max' => 120,
            // Honeypot protection
            'antispam_honeypot'       => true,
            'antispam_honeypot_class' => 'hide-me',
            'antispam_honeypot_field' => 'subject',
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            //send mail
            $message = (new Swift_Message('Nouveau Contact'))
                ->setFrom($contact['email'])
                ->setTo('retrocyclingcontact@gmail.com')

                //Create the message and send it to the emails template
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig',
                        ['contact' => $contact],
                    ),
                    'text/html'
                )
            ;
            //We send the message
            $mailer->send($message);
            $this->addFlash('message', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('front_home');
        }
        return $this->render('front/contact_us.html.twig', [
            'contactForm' => $form ->createView(),
            'background_pictures' => $backgroundRepository->findByName('background-contact')
        ]);
    }

    /**
     * @Route("/", name="home")
     * Displays the page showing cycling shirts from each categories
     * @return Response
     */
    public function homeCollection(
        CyclingShirtRepository $shirtRepository,
        ArticleRepository $articleRepository,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        $articles = $articleRepository->findBy(
            [],
            ['createdAt' => 'desc'],
            4,
            0
        );

        return $this->render('front/home.html.twig', [
            'cyclingShirts50_60' => $shirtRepository->findBy(
                ['years' => 'Années 50-60'],
                ['id' => 'DESC'],
                3
            ),
            'cyclingShirts70' => $shirtRepository->findBy(
                ['years' => 'Années 70'],
                ['id' => 'DESC'],
                3
            ),
            'cyclingShirts80' => $shirtRepository->findBy(
                ['years' => 'Années 80'],
                ['id' => 'DESC'],
                3
            ),
            'cyclingShirts90' => $shirtRepository->findBy(
                ['years' => 'Années 90'],
                ['id' => 'DESC'],
                3
            ),
            'articles' => $articles,
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     * This controler takes all articles and posters in the blog
     * @return Response
     */
    public function blog(
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        return $this->render('front/blog.html.twig', [
            'articles' => $articleRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/article/{id<^[0-9]+$>}", name="article",  methods={"GET","POST"})
     * This controller displays a blog article and all its content
     * @return Response
     */
    public function article(
        Request $request,
        ArticleRepository $articleRepository,
        ArticleContentRepository $contentRepository,
        int $id,
        Article $article,
        CommentRepository $commentRepository,
        BackgroundPictureRepository $backgroundRepository,
        EntityManagerInterface $manager
    ): Response {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $comment->setUser($user); /** @phpstan-ignore-line */
            $comment->setCreatedAt(new DateTime());
            $comment->setArticle($article);

            // We retrieve the content of the parentid field
            $parentid = $form->get("parentid")->getData();
            if ($parentid != null) {
                // we will look for the corresponding comment
                $parent = $manager->getRepository(Comment::class)->find($parentid);
            }

            // we define the parrent
            $comment->setParent($parent ?? null);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('front_article', ['id' => $id]);
        }

        $comments = $commentRepository->findBy(['article' => $article]);

        return $this->render('front/article.html.twig', [
            'article' => $articleRepository->findOneBy(
                ['id' => $id]
            ),
            'articleContents' => $contentRepository->findBy(['article' => $article]),
            'commentForm' => $form->createView(),
            'comments' => $comments,
            'background_pictures' => $backgroundRepository->findByName('background-main'),
        ]);
    }

    /**
     * @Route("/mentions-légales", name="legal_notice")
     * This controler displays the legal notices
     * @return Response
     */
    public function legalNotice(): Response
    {
        return $this->render('front/legal_notice.html.twig');
    }

    /**
     * @Route("/politique-de-confidentialité", name="privacy_policy")
     * This controler displays the privacy policy
     * @return Response
     */
    public function privacyPolicy(): Response
    {
        return $this->render('front/privacy_policy.html.twig');
    }
}
