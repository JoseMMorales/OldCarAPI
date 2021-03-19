<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

/**
 * @Route("/cars")
 */
class CarsController extends AbstractController
{
    /**
     * @Route("/search", name="route", methods={"GET"})
     */
    public function search(Request $request, CarsRepository $carsRepository) : Response
    {
        $brand = $request->query->get('brand', 0);
        $model =  $request->query->get('model', 0);
        $seller = $request->query->get('seller', 0);
        $year = $request->query->get('year', 0);
        $km = $request->query->get('km', 0);
        $price = $request->query->get('price', 0);

        $cars= $carsRepository->searchCars($brand, $model, $seller, $year, $km, $price);

        return new JsonResponse($cars);
    }

    /**
     * @Route("/details/{id}", name="details", methods={"GET"})
     */
    public function details(int $id, CarsRepository $carsRepository) : Response
    {
        $car= $carsRepository->detailsCars($id);
        return new JsonResponse($car);
    }

    /**
     * @Route("/published", name="data_user_published", methods={"GET"})
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
     * @Route("/deleted/{idCar}", name="data_user_deleted", methods={"DELETE"})
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
     * @Route("/updated/{idCar}", name="data_user_updated", methods={"POST"})
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

        $cars = $carsRepository->find(['user' => $idCar]);

        $car = new Cars();
        $car->setActive(0);
        $car->setCarYear($year);
        $car->setKm($km);
        $car->setShortDescription($shortDescription);
        $car->setLongDescription($longDescription);
        $car->setCarPrice($price);
       
        
        dump($cars);

        $response = [ 'id' => $idCar ];

        return new JsonResponse($response); 
    }
}
