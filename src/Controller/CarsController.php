<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CarsRepository;

class CarsController extends AbstractController
{
    /**
     * @Route("/search", name="route", methods={"GET"})
     */
    public function queryBuilder(Request $request, CarsRepository $carsRepository) : Response
    // int $km ,int $year, int $price
    {
        $brand = $request->query->get('brand', 0);
        $model =  $request->query->get('model', 0);
        $seller = $request->query->get('seller', 0);

        $cars= $carsRepository->searchCars($brand, $model, $seller);
        // $km, $year, $price);
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
