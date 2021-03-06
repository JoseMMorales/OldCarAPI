<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UsersRepository;
use App\Entity\Users;

class UserController extends AbstractController
{
    /**
     * @Route("user/data/{id}", name="data_user", methods={"GET"})
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
        // print_r($userObj['email']);
    
        return new JsonResponse($userObj);
    }

    /**
     * @Route("user/add", name="add_user", methods={"POST","GET"})
     */
    public function addUser(Request $request, EntityManagerInterface $em): Request
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        $user = new Users();
        $user->setActive(1);
        $user->setName('test');
        $user->setEmail('test');
        $user->setPassword('test');

        $em->persist($user);
        $em->flush();

        $response = [];
        $response['id'] = $user-> getUserId();
        $response['name'] = $user->getName();
        $response['email'] = $user->getEmail();
        $response['address'] = $user->getAddress();
        $response['city'] = $user->getCity();
        $response['phone'] = $user->getPhone();
        
        return new JsonResponse($response);
    }
}
