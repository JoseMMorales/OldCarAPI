<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UsersRepository;

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
}
