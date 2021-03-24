<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UsersRepository;
use App\Entity\Users;

class AdminController extends AbstractController
{
    /**
     * @Route("/users", name="users", methods={"GET"})
     */
    public function users(UsersRepository $repoUser): Response
    {
        $users = $repoUser->findAll();

        dump($users);

        $response = [];
        foreach ($users as $user) {
            
            $userObj = [
                'id' => $user->getId(),
                'active' => $user->getActive(),
                'name'=> $user->getName(),
                'email' => $user->getEmail(),
                'address' => $user->getAddress(),
                'phone' => $user->getType(),
                'roles' => $user->getRoles(),
                'type' => $user->getType()
            ];
            $response[] = $userObj;

            dump($response);
        };

        return new JsonResponse($user);
    }
}
