<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\FavouritesRepository;
use Symfony\Component\Routing\Annotation\Route;

class FavouritesController extends AbstractController
{
    /**
     * @Route("/favourites", name="favourites", methods={"GET"})
     */
    public function favourites(FavouritesRepository $repo): Response
    {
        $car = $this->getUser();
        
        $userObj = [
            'id' => $user-> getUserId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'address' => $user->getAddress(),
            'city' => $user->getCity(),
            'phone' => $user->getPhone(),
            'type' => $user->getType()
        ];
    
        return new JsonResponse($userObj);
    }
}
