<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    /**
     * @Route("/details/{id}", name="searchCar")
     * @Method({"GET"})
     */
    public function details( int $id = null): Response
    {   
        $idJson = json_encode($id, JSON_PRETTY_PRINT);

        return new Response($idJson);
    }
}
