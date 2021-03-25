<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UsersRepository;
use App\Repository\CarsRepository;
use App\Entity\Users;
use App\Entity\Cars;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/users", name="admin_users", methods={"GET"})
     */
    public function adminUsers(UsersRepository $repoUser): Response
    {
        $users = $repoUser->findAll();

        $response = [];
        foreach ($users as $user) {
            
            $userObj = [
                'id' => $user->getId(),
                'active' => $user->getActive(),
                'name'=> $user->getName(),
                'email' => $user->getEmail(),
                'address' => $user->getAddress(),
                'phone' => $user->getPhone(),
                'roles' => $user->getRoles(),
                'type' => $user->getType()
            ];
            $response[] = $userObj;
        };

        return new JsonResponse($response);
    }

    /**
     * @Route("/delete/user/{id}", name="admin_delete_user", methods={"DELETE"})
     */
    public function adminDeleteUser(
        int $id,
        UsersRepository $repoUser,
        EntityManagerInterface $em): Response
    {
        $user = $repoUser->find($id);
        $em->remove($user);
        $em->flush();

        $response = [ 
            'code' => 200,
            'message' => 'Account deleted' 
        ];

        return new JsonResponse($response); 
    }

    /**
     * @Route("/cars", name="admin_cars", methods={"GET"})
     */
    public function adminCars( CarsRepository $repoCars ): Response
    {
        $cars = $repoCars->findAll();

        $response = [];
        foreach ($cars as $car) {
            $userObj = [
                'id' => $car->getId(),
                'active' => $car->getActive(),
                'brand'=> $car->getModel()->getBrand()->getBrandName(),
                'model' => $car->getModel()->getModelName(),
                'year' => $car->getCarYear(),
                'price' => $car->getCarPrice(),
                'km' => $car->getKm(),
                'user' => $car->getUser()->getName()
            ];
            $response[] = $userObj;
        };

        return new JsonResponse($response);
    }

    /**
     * @Route("/delete/car/{id}", name="admin_delete_car", methods={"DELETE"})
     */
    public function adminDeleteCar(
        int $id,
        CarsRepository $repoCars,
        EntityManagerInterface $em): Response
    {
        $car = $repoCars->find($id);
        $em->remove($car);
        $em->flush();

        $response = [ 
            'code' => 200,
            'message' => 'Account deleted' 
        ];

        return new JsonResponse($response); 
    }
}
