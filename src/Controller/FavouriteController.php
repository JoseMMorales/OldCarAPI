<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
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
        // $user = $repoUser->find($id);
       
        // $favouritesArray = [];
        // $favourites = $user->getCars();
        
        // foreach ($favourites as $favourite) {

        //     $favouriteObj = [
        //         "idCar" => $favourite->getId(),
        //         "year" => $favourite->getCarYear(),
        //         "km" => $favourite->getKm(),
        //         "price" => $favourite->getCarPrice(),
        //         "idModel" => $favourite->getModel(),
        //         "image" => $favourite->getMainImage()
        //     ];
        //     $favouritesArray[] = $favouriteObj;
        // }

        // dump($favouritesArray);

        // $userObj = [
        //     "idUser" => $user-> getId(),
        //     "name" => $user->getName(),
        //     "favouriteCars" => $favouritesArray
        // ];

        // return new JsonResponse($favouritesArray);

        $cars= $repoUser->favouriteCars($id);
      
        return new JsonResponse($cars);
    }

    /**
     * @Route("/addFavourite/{id}", name="addFavourite", methods={"POST"})
     */
    public function addFavourite(int $id, CarsRepository $repoCars, UsersRepository $repoUsers, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $car = $repoCars->findOneBy(['id' => $id]);

        dump($car);
        dump($user);

        $user = new Users;
        $user->addCars($car);

        $em->persist($user);
        $em->flush();

        $response = [ 'favouriteCar' => 'Favourite Car deleted' ];

        return new JsonResponse($response); 
    }

    /**
     * @Route("/deleteFavourite/{id}", name="deleteFavourite", methods={"DELETE"})
     */
    public function deleteFavourite(int $id, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $em->removeCars($id);
        $em->flush();

        $response = [ 'favouriteCar' => 'Favourite Car deleted' ];

        return new JsonResponse($response); 
    }
}
