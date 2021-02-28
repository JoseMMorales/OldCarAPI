<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CarsRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/cars")
 */
class CarsController extends AbstractController
{
    /**
     * @Route("/brands", name="brands")
     */
    public function queryBuilder(EntityManagerInterface $em) : Response
    {
        $qb = $em->createQuery( "SELECT u, m
                                FROM App:Cars u 
                                JOIN u.model m
                                WHERE m.modelName = '2CV'");
        $data = $qb->getResult();
        $carsArray = [];

        // var_dump($data);

        foreach ($data as $car) {
            $carObj = [
                'id' => $car-> getCarId(),
                'year' => $car->getCarYear(),
                'km' => $car->getKm(),
                'description' => $car->getShortDescription(),
                'price' => $car->getCarPrice(),
                'image' => $car->getMainImage(),
                // 'modelID' => $car->getModel()->getId()
            ];
            $carsArray[] = $carObj;
        }
        return new JsonResponse($carsArray);
    }
}
