<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CarsRepository;
use App\Repository\UsersRepository;
use App\Entity\Users;
use App\Entity\Cars;

class FavouriteController extends AbstractController
{
    /**
     * @Route("/favourite/{id}", name="favourite", methods={"GET"})
     */
    public function favourite(int $id, UsersRepository $repoUser): Response
    {
        $cars= $repoUser->favouriteCars($id);
      
        return new JsonResponse($cars);
    }

    /**
     * @Route("/addFavourite/{id}", name="addFavourite", methods={"POST"})
     */
    public function addFavourite(
        int $id, 
        CarsRepository $repoCars,
        UsersRepository $repoUser, 
        EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $car = $repoCars->findOneBy(['id' => $id]);

        $carsExist = $user->getCars();

        foreach ($carsExist as $key => $carsExist) {
            if ($carsExist->getId() === $id) {
                $carObj = ['idCar' => 0];
                break;
            } else {
                $user->addCars($car);
                $em->persist($user);
                $em->flush();
              
                $imageURL = "http://localhost:8000/img/";
                $imageName = $car->getMainImage();

                $imageConcatURL = $imageURL.$imageName;

                $carObj = [
                    'idUser' => $user->getId(),
                    'idCar' => $car->getId(),
                    'carYear' => $car->getCarYear(),
                    'carPrice' => $car->getCarPrice(),
                    'image' => "$imageConcatURL",
                    'model' => $car->getModel()->getModelName(),
                    'brand' => $car->getModel()->getBrand()->getBrandName(),
                ];
            }
        }           
        return new JsonResponse($carObj); 
    }

    /**
     * @Route("/deleteFavourite/{id}", name="deleteFavourite", methods={"DELETE"})
     */
    public function deleteFavourite(
        int $id, 
        CarsRepository $repoCars, 
        EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $car = $repoCars->findOneBy(['id' => $id]);

        $user->removeCars($car);
        $em->flush();

        $response = ['idCar' => $car->getId()];

        return new JsonResponse($response); 
    }
}
