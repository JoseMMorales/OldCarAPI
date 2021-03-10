<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class PublishController extends AbstractController
{
    /**
     * @Route("/publish", name="publish", methods={"POST"})
     */
    public function publish(Request $request, EntityManagerInterface $em): Response
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $city = $request->get('city');
        $type = $request->get('type');

        $brand = $request->get('brand');
        $model = $request->get('model');
        $km = $request->get('km');
        $price = $request->get('price');
        $year = $request->get('year');
        $shortDescription = $request->get('shortDescription');
        $longDescription = $request->get('longDescription');
        $files = $request->files->get('files');

        $user = new Users();
        $user->setActive(0);
        $user->setName($username);
        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setAddress($address);
        $user->setCity($city);
        $user->setType($type);
        $user->setRoles([]);
        
        $car = new Cars();
        $car->setActive(0);
        $car->setCarYear($year);
        $car->setKm($km);
        $car->setShortDescription($shortDescription);
        $car->setLongDescription($longDescription);
        $car->setCarPrice($price);

        $em->persist($contact);
        $em->flush();

        $mainFileName = 0;

        if ($files[0]) {
            $mainFileName = "$brand"."/$model"."/IMG1.jpg";
        }
        if ($files[1]) {
            $mainFileName = "$brand"."/$model"."/IMG2.jpg";
        }
        if ($files[2]) {
            $mainFileName = "$brand"."/$model"."/IMG1.jpg";
        }
        if ($files[3]) {
            $mainFileName = "$brand"."/$model"."/IMG1.jpg";
        }
        if ($files[4]) {
            $mainFileName = "$brand"."/$model"."/IMG1.jpg";
        }

        $car->setMainImage($files[0]);
        $car->setSecondImage($files[1]);
        $car->setThirdImage($files[2]);
        $car->getFourthImage($files[3]);
        $car->setFifthImage($files[4]);

        $em->persist($contact);
        $em->flush();

        return $this->json($response);
    }
}
