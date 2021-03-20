<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

/**
 * @Route("/published")
 */

class PublishedCarController extends AbstractController
{
    /**
     * @Route("/cars", name="data_user_published", methods={"GET"})
     */
    public function published(CarsRepository $carsRepository): Response
    {
        $user = $this->getUser();
        $id = $user->getId();
        $cars = $carsRepository->findBy(['user' => $id]);

        $carsArray = [];
        $imageURL = $this->getParameter('photos_cars_URL');

        foreach ($cars as $car) {
            $carObj = [
                'idCar' => $car->getId(),
                'km' => $car->getKm(),
                'price' => $car->getCarPrice(),
                'year' => $car->getCarYear(),
                'model' => $car->getModel()->getModelName(),
                'brand' => $car->getModel()->getBrand()->getBrandName(),
                'shortDescription' => $car->getShortDescription(),
                'longDescription' => $car->getLongDescription(),
                'imageMain' => $car->getMainImage(),
                'imageSecond' => $car->getSecondImage(),
                'imageThird' => $car->getThirdImage(),
                'imageFourth' => $car->getFourthImage(),
                'imageFifth' => $car->getFifthImage(),
            ];
            $carObj['imageMain'] = $imageURL.$carObj['imageMain'];
            $carObj['imageSecond'] = $imageURL.$carObj['imageSecond'];
            $carObj['imageThird'] = $imageURL.$carObj['imageThird'];
            $carObj['imageFourth'] = $imageURL.$carObj['imageFourth'];
            $carObj['imageFifth'] = $imageURL.$carObj['imageFifth'];
            $carsArray[] = $carObj;
        }
        return new JsonResponse($carsArray);
    }

    /**
     * @Route("/delete/{idCar}", name="data_user_deleted", methods={"DELETE"})
     */
    public function deleted(
        int $idCar, 
        CarsRepository $carsRepository, 
        EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $idUser = $user->getId();
        $cars = $carsRepository->findBy(['user' => $idUser]);
        
        foreach ($cars as $car) {
            $carBDId = $car->getId();

           if($carBDId === $idCar) {
                $em->remove($car);
                $em->flush();
           }
        };

        $response = [ 'id' => $idCar ];

        return new JsonResponse($response); 
    }

    /**
     * @Route("/update/{idCar}", name="data_user_updated", methods={"POST"})
     */
    public function updated(
        int $idCar, 
        Request $request, 
        UsersRepository $repoUsers,
        CarsRepository $repoCar,
        ModelsRepository $repoModel, 
        BrandsRepository $repoBrands,
        EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
       
        $km = $request->get('km');
        $price = $request->get('price');
        $year = $request->get('year');
        $shortDescription = $request->get('shortDescription');
        $longDescription = $request->get('longDescription');
        $price = $request->get('price');

        dump($year);

        $car = $repoCar->find(['id' => $idCar]);
        $car->setCarYear($year);
        $car->setKm($km);
        $car->setShortDescription($shortDescription);
        $car->setLongDescription($longDescription);
        $car->setCarPrice($price);

        $em->persist($car);
        $em->flush();

        $carsArray = [];
        $imageURL = $this->getParameter('photos_cars_URL');

        $carObj = [
            'code' => 200,
            'idCar' => $car->getId(),
            'km' => $car->getKm(),
            'price' => $car->getCarPrice(),
            'year' => $car->getCarYear(),
            'model' => $car->getModel()->getModelName(),
            'brand' => $car->getModel()->getBrand()->getBrandName(),
            'shortDescription' => $car->getShortDescription(),
            'longDescription' => $car->getLongDescription(),
            'imageMain' => $car->getMainImage(),
            'imageSecond' => $car->getSecondImage(),
            'imageThird' => $car->getThirdImage(),
            'imageFourth' => $car->getFourthImage(),
            'imageFifth' => $car->getFifthImage(),
        ];

        $carObj['imageMain'] = $imageURL.$carObj['imageMain'];
        $carObj['imageSecond'] = $imageURL.$carObj['imageSecond'];
        $carObj['imageThird'] = $imageURL.$carObj['imageThird'];
        $carObj['imageFourth'] = $imageURL.$carObj['imageFourth'];
        $carObj['imageFifth'] = $imageURL.$carObj['imageFifth'];

        return new JsonResponse($carObj); 
    }
}
