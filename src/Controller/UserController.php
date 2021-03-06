<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UsersRepository;
use App\Entity\Users;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="user")
     */
    public function user(int $id , UsersRepository $repo): Response
    {
        $user = $repo->find($id);
        
        $userObj = [
            'id' => $user-> getUserId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'address' => $user->getAddress(),
            'city' => $user->getCity(),
            'phone' => $user->getPhone()
        ];

        print_r($userObj['email']);
    
        return new JsonResponse($userObj);
    }
}
