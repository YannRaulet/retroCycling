<?php

namespace App\Controller;

use App\Entity\CyclingShirt;
use App\Repository\CyclingShirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BackgroundPictureRepository;

/**
 * Creates views that allow users to see the different shirts by years
 * @Route(name="front_")
 */
class FrontCollectionController extends AbstractController
{
    /**
     * @Route("/collection50_60", name="collection50_60")
     * Displays the page showing cycling shirts from the 50s and 60s
     * @return Response
     */
    public function collection5060(
        CyclingShirtRepository $shirtRepository,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        return $this->render('front/collection5060.html.twig', [
            'cyclingShirts50_60' => $shirtRepository->findByYears('Années 50-60'),
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/collection70", name="collection70")
     * Displays the page showing cycling shirts from the 70s
     * @return Response
     */
    public function collection70(
        CyclingShirtRepository $shirtRepository,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        return $this->render('front/collection70.html.twig', [
            'cyclingShirts70' => $shirtRepository->findByYears('Années 70'),
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/collection80", name="collection80")
     * Displays the page showing cycling shirts from the 80s
     * @return Response
     */
    public function collection80(
        CyclingShirtRepository $shirtRepository,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        return $this->render('front/collection80.html.twig', [
            'cyclingShirts80' => $shirtRepository->findByYears('Années 80'),
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/collection90", name="collection90")
     * Displays the page showing cycling shirts from the 90s
     * @return Response
     */
    public function collection90(
        CyclingShirtRepository $shirtRepository,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        return $this->render('front/collection90.html.twig', [
            'cyclingShirts90' => $shirtRepository->findByYears('Années 90'),
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/collection50_60/{id}", name="shirt_cycling50_60")
     * Displays the page featuring the selected cycling shirt from the 50s and 60s
     * @return Response
     */
    public function shirtCycling5060(
        CyclingShirtRepository $shirtRepository,
        int $id,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        return $this->render('front/shirtCycling5060.html.twig', [
            'cyclingShirt50_60' => $shirtRepository->findOneBy(
                ['id' => $id
                ]
            ),
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/collection70/{id}", name="shirt_cycling70")
     * Displays the page featuring the selected cycling shirt from the 70s
     */
    public function shirtCycling70(
        CyclingShirtRepository $shirtRepository,
        int $id,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        return $this->render('front/shirtCycling70.html.twig', [
            'cyclingShirt70' => $shirtRepository->findOneBy(
                ['id' => $id
                ]
            ),
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/collection80/{id}", name="shirt_cycling80")
     * Displays the page featuring the selected cycling shirt from the 80s
     * @return Response
     */
    public function shirtCycling80(
        CyclingShirtRepository $shirtRepository,
        int $id,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        return $this->render('front/shirtCycling80.html.twig', [
            'cyclingShirt80' => $shirtRepository->findOneBy(
                ['id' => $id
                ]
            ),
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }

    /**
     * @Route("/collection90/{id}", name="shirt_cycling90")
     * Displays the page featuring the selected cycling shirt from the 90s
     * @return Response
     */
    public function shirtCycling90(
        CyclingShirtRepository $shirtRepository,
        int $id,
        BackgroundPictureRepository $backgroundRepository
    ): Response {
        return $this->render('front/shirtCycling90.html.twig', [
            'cyclingShirt90' => $shirtRepository->findOneBy(
                ['id' => $id
                ]
            ),
            'background_pictures' => $backgroundRepository->findByName('background-main')
        ]);
    }
}
