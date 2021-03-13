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
     * @Route("/favourite/{id}", name="favourite")
     */
    public function favourite(int $id, UsersRepository $repo): Response
    {
        $user = $repo->find($id);
       
        $favouritesArray = [];
        $favourites = $user->getCars();
        
        foreach ($favourites as $favourite) {
            $favouriteObj = [
                "idCar" => $favourite->getId(),
                "description" => $favourite->getShortDescription(),
            ];
            $favouritesArray[] = $favouriteObj;
        }

        dump($favouritesArray);

        $userObj = [
            "idUser" => $user-> getId(),
            "name" => $user->getName(),
            "favouriteCars" => $favouritesArray
        ];

        return new JsonResponse($userObj);
    }
}
