<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UsersRepository;
use App\Entity\Users;

/**
 * @Route("user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/data/{id}", name="data_user", methods={"GET"})
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
            'phone' => $user->getPhone(),
            'seller' => $user->getType()
        ];
        // print_r($userObj['email']);
    
        return new JsonResponse($userObj);
    }

    /**
     * @Route("/add", name="add_user", methods={"POST","GET"})
     */
    public function addUser(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        $user = new Users();
        $user->setActive(1);
        $user->setName($username);
        $user->setEmail($email);
        $user->setRoles([]);

        $plainPassword = $password;
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);

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
     * @Route("/update/{id}", name="update_user", methods={"PUT","GET"})
     */
    public function updateUser(int $id, Request $request, UsersRepository $repo, EntityManagerInterface $em): Response
    {
        $username = null;
        // $type = 'Particular';
        // $username = $request->get('username');
        // $type = $request->get('type');
        // $email = $request->get('email');
        // $phone = $request->get('phone');
        // $address = $request->get('address');
        // $city = $request->get('city');
        // $password = $request->get('password');

        // $bodyRequest = $request->getContent();
        // $userArray = json_decode($bodyRequest);

        $user = $repo->find($id);
        // if ($username) {
        //     echo($username);
            $user->setName("Test");
            // $user->setName($userArray -> username);
        // };

        // if ($type) {
            // $user->setType("$type");
            // $user->setType($userArray -> type);
        // };

        // if ($email) {
        //     $user->setEmail("$email");
        // }
        // if ($phone) {
        //     $user->setPhone("$phone");
        // }
        // if ($address) {
        //     $user->setAddress("$address");
        // }
        // if ($city) {
        //     $user->setCity("$city");
        // }
        // if ($password) {
        //     $user->setPassword("$password");
        // }
    
        $em->persist($user);
        $em->flush();

        // $response = [];
        // $response['id'] = $user-> getUserId();
        // $response['name'] = $user->getName();
        // $response['email'] = $user->getEmail();
        // $response['address'] = $user->getAddress();
        // $response['city'] = $user->getCity();
        // $response['phone'] = $user->getPhone();
        // $response['seller'] = $user->getType();
        
        return new JsonResponse($user);
    }

    /**
     * @Route("/delete/{id}", name="delete_user", methods={"DELETE","GET"})
     */
    public function delete(int $id, UsersRepository $repo, EntityManagerInterface $em): Response
    {
        $user = $repo->find($id);
        $userName = $user->getName();

        $em->remove($user);
        $em->flush();

        $response = [ 'message' => "$userName" ];

        return new JsonResponse($response); 
    }

}
