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
        EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $car = $repoCars->findOneBy(['id' => $id]);

        $user->addCars($car);
        $em->persist($user);
        $em->flush();

        $response = [ 'favouriteCar' => 'Favourite Car Added on' ];

        return new JsonResponse($response); 
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

        $response = [ 'favouriteCar' => 'Favourite Car deleted' ];

        return new JsonResponse($response); 
    }
}
