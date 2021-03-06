<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CarsRepository;

class CarsController extends AbstractController
{
    /**
     * @Route("/search/{brand}", 
     *         name="route", 
     *         methods={"GET"},
     *         defaults={"brand" = 0, "model" = 0})
     */
    public function queryBuilder(string $brand, CarsRepository $carsRepository) : Response
    // , string $seller = '', int $km = null,int $year = null, int $price = null, CarsRepository $carsRepository) : Response
    {
        $cars= $carsRepository->searchCars($brand);
        // , $seller, $km, $year, $price);
        return new JsonResponse($cars);
    }

    /**
     * @Route("/details/{id}", name="details", methods={"GET"})
     */
    public function detailsCars(int $id, CarsRepository $carsRepository) : Response
    {
        $car= $carsRepository->detailsCars($id);
        return new JsonResponse($car);
    }
}
