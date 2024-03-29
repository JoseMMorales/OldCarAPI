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

        $response = [];

        foreach ($cars as $car) {
            $carObj = [
                'idUser' => $car['idUser'],
                'idCar' => $car['idCar'],
                'carPrice' => $car['carPrice'],
                'image' => $car['image'],
                'model' => $car['modelName'],
                'brand' => $car['brandName']
            ];
            $response[] = $carObj;
        };
        return new JsonResponse($response);
    }

    /**
     * @Route("/addFavourite/{id}", name="addFavourite", methods={"POST"})
     */
    public function addFavourite(
        int $id, 
        CarsRepository $repoCars,
        EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $car = $repoCars->find($id);
        $favourites = $user->getCars();

        if ($favourites->isEmpty()) {
            $carObj = $this->addingCars($user, $car, $em); 
        } else {
            $carExist = false;
            foreach ($favourites as $favourite) {
                if ($favourite->getId() === $id) {
                    $carExist = true;
                    break;
                } 
            }      
            if ($carExist) {
                $carObj = ['idCar' => 0];
            } else {
                $carObj =  $this->addingCars($user, $car, $em); 
            }     
        }
        return new JsonResponse($carObj); 
    }

    private function addingCars($user, $car, $em) 
    {
        $user->addCars($car);
        $em->persist($user);
        $em->flush();
        
        $imageURL = $this->getParameter('photos_cars_URL');
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
        return $carObj;
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
