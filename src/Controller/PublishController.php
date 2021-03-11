<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BrandsRepository;
use App\Repository\ModelsRepository;
use App\Repository\UsersRepository;
use App\Repository\CarsRepository;
use App\Entity\Models;
use App\Entity\Brands;
use App\Entity\Users;
use App\Entity\Cars;

class PublishController extends AbstractController
{
    /**
     * @Route("/publish", name="publish", methods={"POST"})
     */
    public function publish(
        Request $request, 
        UsersRepository $repoUsers,
        CarsRepository $repoCar,
        ModelsRepository $repoModel, 
        BrandsRepository $repoBrands,
        EntityManagerInterface $em): Response
    {
        $username = $request->get('username');
        $newEmail = $request->get('email');
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
        $photos[0] = $request->files->get('file0');
        $photos[1] = $request->files->get('file1');

        dump($request->files->get('file'));
        dump($photos);

        $user = $repoUsers->findOneBy(['email' => $newEmail]);

        if ($user) {
           $user->setEmail($newEmail);
           $em->persist($user);
        } else {
            $user = new Users();
            $user->setActive(0);
            $user->setName($username);
            $user->setEmail($newEmail);
            $user->setPhone($phone);
            $user->setAddress($address);
            $user->setCity($city);
            $user->setType($type);
            $user->setRoles([]);
            $em->persist($user);
        }
        
        $car = new Cars();
        $car->setActive(0);
        $car->setCarYear($year);
        $car->setKm($km);
        $car->setShortDescription($shortDescription);
        $car->setLongDescription($longDescription);
        $car->setCarPrice($price);
        $car->setUser($user);

        $newModel = $repoModel->findOneBy(['modelName' =>  $model]);

        if($newModel){
            $car->setModel($newModel);
        } else {
            $newModel = new Models();
            $newModel->setModelName($model);
            $car->setModel($newModel);
            $em->persist($newModel);
        }

        $existBrand = $repoBrands->findOneBy(['brandName' => $brand]);

        if($existBrand) {
            $newModel->setBrand($existBrand);
            $em->persist($newModel);
        } else {
            $newBrand = new Brands();
            $newBrand->setBrandName($brand);
            $newModel->setBrand($newBrand);
            $em->persist($newBrand);
        }
        
        $em->persist($car);
        $em->flush();
        $carId = $car->getCarId();

        $photoNames = [];
        $dir = $this->getParameter('photos_cars');

        foreach ($photos as $key => $photo) {
            $index = $key + 1; 
            $photoName = "/$carId"."-IMG$index.jpg";
            $photo->move($dir."$brand"."/$model", $photoName);
            $photoNames[] = $photoName;
        };

        $car->setMainImage($photoName[0]);
        $car->setSecondImage($photoName[1]);
        // $car->setThirdImage($photoName[2]);
        // $car->setFourthImage($photoName[3]);
        // $car->setFifthImage($photoName[4]);

        $em->persist($car);
        $em->flush();

        $response = ["Car and User uploaded onto DDBB"];

        return $this->json($response);
    }
}
