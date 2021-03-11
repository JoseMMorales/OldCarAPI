<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavouritesController extends AbstractController
{
    /**
     * @Route("/favourites", name="favourites")
     */
    public function index(): Response
    {
        return $this->render('favourites/index.html.twig', [
            'controller_name' => 'FavouritesController',
        ]);
    }
}
