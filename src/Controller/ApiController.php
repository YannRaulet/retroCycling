<?php

namespace App\Controller;

use App\Repository\CyclingShirtRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This controller will return Json responses for the Leaflet map ajax requests
 * @Route( "/api", name="api_")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/map", name="map")
     * Collect all years cycling shirts
     * @return Response
     */
    public function map(CyclingShirtRepository $shirtsRepository): Response
    {
        $cyclingShirt = $shirtsRepository->findAll();
        return $this->json($cyclingShirt, 200);
    }

    /**
    * @Route("/filter50_60", name="filter50_60")
    * Collect cycling shirts 50s and 60s
    * @return Response
    */
    public function filter5060(CyclingShirtRepository $shirtsRepository): Response
    {
        $filter5060 = $shirtsRepository->findByYears('Années 50-60');
        return $this->json($filter5060, 200);
    }

    /**
    * @Route("/filter70", name="filter70")
    * Collect cycling shirts 70s
    * @return Response
    */
    public function filter70(CyclingShirtRepository $shirtsRepository): Response
    {
        $filter70 = $shirtsRepository->findByYears('Années 70');
        return $this->json($filter70, 200);
    }

    /**
    * @Route("/filter80", name="filter80")
    * Collect cycling shirts 80s
    * @return Response
    */
    public function filter80(CyclingShirtRepository $shirtsRepository): Response
    {
        $filter80 = $shirtsRepository->findByYears('Années 80');
        return $this->json($filter80, 200);
    }

    /**
    * @Route("/filter90", name="filter90")
    * Collect cycling shirts 90s
    * @return Response
    */
    public function filter90(CyclingShirtRepository $shirtsRepository): Response
    {
        $filter90 = $shirtsRepository->findByYears('Années 90');
        return $this->json($filter90, 200);
    }
}
