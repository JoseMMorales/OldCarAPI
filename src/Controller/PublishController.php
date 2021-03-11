<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CarsRepository;
use App\Entity\Users;
use App\Entity\Cars;
use App\Entity\Models;
use App\Entity\Brands;


class PublishController extends AbstractController
{
    /**
     * @Route("/publish", name="publish", methods={"POST"})
     */
    public function publish(Request $request, CarsRepository $repo, EntityManagerInterface $em): Response
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $city = $request->get('city');
        $type = $request->get('type');

        $brand = $request->get('brand');
        $model = $request->get('model');

        print_r($brand);

        $km = $request->get('km');
        $price = $request->get('price');
        $year = $request->get('year');
        $shortDescription = $request->get('shortDescription');
        $longDescription = $request->get('longDescription');
        $photos = $request->files->get('files');

        $user = new Users();
        $user->setActive(0);
        $user->setName($username);
        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setAddress($address);
        $user->setCity($city);
        $user->setType($type);
        $user->setRoles([]);

        $brand = new Brands();
        $brand->setBrandName($brand);

        $model = new Models();
        $model->setModelName($model);
        
        $car = new Cars();
        $car->setActive(0);
        $car->setCarYear($year);
        $car->setKm($km);
        $car->setShortDescription($shortDescription);
        $car->setLongDescription($longDescription);
        $car->setCarPrice($price);

        $em->persist($user);
        $em->persist($brand);
        $em->persist($model);
        $em->persist($car);
        $em->flush();
        $carId = $repo->getCarId();

        $photoName = 0;
        $dir = $this->getParameter('photos_cars');

        foreach ($files as $key => $file) {
            $photoName = "$brand"."/$model"."/$carId"."/IMG$key.jpg";
            $photos->move($dir, $photoName);
        };

        $car->setMainImage($photoName[0]);
        $car->setSecondImage($photoName[1]);
        $car->setThirdImage($photoName[2]);
        $car->getFourthImage($photoName[3]);
        $car->setFifthImage($photoName[4]);

        $em->persist($car);
        $em->flush();

        $response = ["Car and User uploaded onto DDBB"];

        return $this->json($response);
    }
}
