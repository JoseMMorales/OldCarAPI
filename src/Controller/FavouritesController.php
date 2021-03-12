<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UsersRepository;
use Symfony\Component\Routing\Annotation\Route;

class FavouritesController extends AbstractController
{
    /**
     * @Route("/favourites/{id}", name="favourites")
     */
    public function favourites(int $id, UsersRepository $repo): Response
    {
        $favourites = $repo->find($id);

        if ($curso === null) {
            throw $this->createNotFoundException('Favourite not found, please try again!!');
        };

        $favouritesObj = [

        ];

        return $this->json($favouritesObj);
    }
}
