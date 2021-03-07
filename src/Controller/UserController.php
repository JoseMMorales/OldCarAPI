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
    public function addUser(Request $request, EntityManagerInterface $em): Response
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        $user = new Users();
        $user->setActive(1);
        $user->setName($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles([]);

        $em->persist($user);
        $em->flush();

        $response = [];
        $response['id'] = $user-> getUserId();
        $response['name'] = $user->getName();
        $response['email'] = $user->getEmail();
        $response['address'] = $user->getAddress();
        $response['city'] = $user->getCity();
        $response['phone'] = $user->getPhone();
        $response['seller'] = $user->getType();
        
        return $this->json($response);
    }

    /**
     * @Route("user/update/{id}", name="update_user", methods={"PUT","GET"})
     */
    public function updateUser(int $id, Request $request, UsersRepository $repo, EntityManagerInterface $em): Request
    {
        $username = $request->get('username');
        $type = $request->get('type');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $city = $request->get('city');
        $password = $request->get('password');


        $user = $repo->find($id);
        $curso->setNombre($cursoArray -> nombre);
    
    
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
