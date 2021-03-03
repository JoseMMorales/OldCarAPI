<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
// use App\Repository\SearchRepository; 

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('App:Search');
        $cars= $repository->searchCars();
    
        return new JsonResponse($cars);
    }
}
