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
     * @Route("/data", name="data_user", methods={"GET"})
     */
    public function user(): Response
    {
        $user = $this->getUser();
        
        $userObj = [
            'id' => $user-> getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'address' => $user->getAddress(),
            'city' => $user->getCity(),
            'phone' => $user->getPhone(),
            'type' => $user->getType()
        ];
    
        return new JsonResponse($userObj);
    }

    /**
     * @Route("/add", name="add_user", methods={"POST"})
     */
    public function addUser( 
        Request $request, 
        UsersRepository $repoUsers,
        EntityManagerInterface $em, 
        UserPasswordEncoderInterface $encoder): Response
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        $user = $repoUsers->findOneBy(['email' => $email]);

        if ($user) {
            $messageNo = 'Usuario creado en Database, inténtalo otra vez!!';
            $response = [
                'message' => $messageNo , 
                'code' => 400
            ];
        } else {
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

            $messageOk = 'Usuario creado!!';
    
            $response = [
                'message' => $messageOk , 
                'code' => 200,
                'id' => $user-> getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'address' => $user->getAddress(),
                'city' => $user->getCity(),
                'phone' => $user->getPhone(),
                'type' => $user->getType()
            ];
        }
        return $this->json($response);
    }

    /**
     * @Route("/update", name="update_user", methods={"POST"})
     */
    public function updateUser( 
        Request $request, 
        UsersRepository $repo, 
        EntityManagerInterface $em, 
        UserPasswordEncoderInterface $encoder): Response
    {
        $username = $request->get('username');
        $type = $request->get('type');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $city = $request->get('city');
        $password = $request->get('password');
        
        $user = $this->getUser();
        $user->setName($username);
        $user->setType($type);
        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setAddress($address);
        $user->setCity($city);

        if ($password) {
            $plainPassword = $password;
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);
        }
    
        $em->persist($user);
        $em->flush();

        $response = [];
        $response['id'] = $user-> getId();
        $response['name'] = $user->getName();
        $response['email'] = $user->getEmail();
        $response['address'] = $user->getAddress();
        $response['city'] = $user->getCity();
        $response['phone'] = $user->getPhone();
        $response['type'] = $user->getType();
        
        return new JsonResponse($response);
    }

    /**
     * @Route("/delete", name="delete_user", methods={"DELETE"})
     */
    public function delete(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $em->remove($user);
        $em->flush();

        $response = [ 'message' => 'Account deleted' ];

        return new JsonResponse($response); 
    }

}
