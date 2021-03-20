<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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

class PublishUserController extends AbstractController
{
    /**
     * @Route("/publish/user", name="publish_user", methods={"POST"})
     */
    public function publishUser(
        Request $request, 
        UsersRepository $repoUsers,
        CarsRepository $repoCar,
        ModelsRepository $repoModel, 
        BrandsRepository $repoBrands,
        EntityManagerInterface $em ): Response
    {
        $user = $this->getUser();

        $brand = $request->get('brand');
        $model = $request->get('model');
        $km = $request->get('km');
        $price = $request->get('price');
        $year = $request->get('year');
        $shortDescription = $request->get('shortDescription');
        $longDescription = $request->get('longDescription');
        $photos[0] = $request->files->get('file0');
        $photos[1] = $request->files->get('file1');
        $photos[2] = $request->files->get('file2');
        $photos[3] = $request->files->get('file3');
        $photos[4] = $request->files->get('file4');

        $car = new Cars();
        $car->setActive(1);
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
        $carId = $car->getId();

        $photoNames = [];
        $dir = $this->getParameter('photos_cars');

        foreach ($photos as $key => $photo) {
            if (!$photo) {
                $photoName = "Default/defaultImage.jpg";
            } else {
                $index = $key + 1; 
                $extension = $photo->getClientOriginalExtension();
                $brandNotSpace = str_replace(' ', '', $brand);
                $modelNotSpace = str_replace(' ', '', $model);
                $photoName = "$brandNotSpace"."/$modelNotSpace"."/$carId"."-IMG$index.$extension";
                $photo->move($dir."$brandNotSpace"."/$modelNotSpace", $photoName);
            }
            $photoNames[] = $photoName;
        };

        $car->setMainImage($photoNames[0]);
        $car->setSecondImage($photoNames[1]);
        $car->setThirdImage($photoNames[2]);
        $car->setFourthImage($photoNames[3]);
        $car->setFifthImage($photoNames[4]);

        $em->persist($car);
        $em->flush();

        $imageURL = $this->getParameter('photos_cars_URL');
        $imageName = $car->getMainImage();

        $imageConcatURL = $imageURL.$imageName;

        $response = [
            'idCar'=> $car->getId(),
            'imageMain'=> "$imageConcatURL",
            'model' => $car->getModel()->getModelName(),
            'brand' => $car->getModel()->getBrand()->getBrandName()
        ];

        return $this->json($response);
    }
}
