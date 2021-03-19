<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BrandsRepository;
use App\Repository\ModelsRepository;
use App\Repository\UsersRepository;
use App\Repository\CarsRepository;
use App\Entity\Models;
use App\Entity\Brands;
use App\Entity\Users;
use App\Entity\Cars;

/**
 * @Route("/cars")
 */
class CarsController extends AbstractController
{
    /**
     * @Route("/search", name="route", methods={"GET"})
     */
    public function search(Request $request, CarsRepository $carsRepository) : Response
    {
        $brand = $request->query->get('brand', 0);
        $model =  $request->query->get('model', 0);
        $seller = $request->query->get('seller', 0);
        $year = $request->query->get('year', 0);
        $km = $request->query->get('km', 0);
        $price = $request->query->get('price', 0);

        $cars= $carsRepository->searchCars($brand, $model, $seller, $year, $km, $price);

        return new JsonResponse($cars);
    }

    /**
     * @Route("/details/{id}", name="details", methods={"GET"})
     */
    public function details(int $id, CarsRepository $carsRepository) : Response
    {
        $car= $carsRepository->detailsCars($id);
        return new JsonResponse($car);
    }
}
