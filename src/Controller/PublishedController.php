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
class PublishedController extends AbstractController
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
     * @Route("/deleteImage", name="data_user_delete_image", methods={"DELETE"})
     */
    public function deleteImage(
        Request $request,
        EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $name = $request->query->get('picture');
        $idCar = $request->query->get('idCar');

        dump($name);

        if ($name instanceof Blob) {
            $result['code2'] = 200;
        } else {
            $qb = $em->getRepository('App:Cars')->createQueryBuilder('c');
            $qb ->select('c')
                ->where($qb->expr()->orX(
                    $qb->expr()->eq('c.mainImage', ':name'),
                    $qb->expr()->eq('c.secondImage', ':name'),
                    $qb->expr()->eq('c.thirdImage', ':name'),
                    $qb->expr()->eq('c.fourthImage', ':name'),
                    $qb->expr()->eq('c.fifthImage', ':name')
                ))
                ->andWhere('c.id = :id')
                ->setParameters(array(
                    'name' => $name,
                    'id' => $idCar
                ));
              
            $car = $qb->getQuery()->getSingleResult();
    
            $result = [];
    
            if (str_contains($name, 'Default')) {
                $sameName = $name;
                $result['code'] = 200;
            } else {
                $carModel = $car->getModel()->getmodelName();
                $carBrand = $car->getModel()->getBrand()->getBrandName();
    
                $dir = $this->getParameter('photos_cars');

                unlink("$dir/$name");
    
                if ($car->getMainImage() === $name) {
                    $car->setMainImage('Default/defaultImage1.jpg');
                    $result['code'] = 200;
                }
                if ($car->getSecondImage() === $name) {
                    $car->setSecondImage('Default/defaultImage2.jpg');
                    $result['code'] = 200;
                }
                if ($car->getThirdImage() === $name) {
                    $car->setThirdImage('Default/defaultImage3.jpg');
                    $result['code'] = 200;
                }
                if ($car->getFourthImage() === $name) {
                    $car->setFourthImage('Default/defaultImage4.jpg');
                    $result['code'] = 200;
                }
                if ($car->getFifthImage() === $name) {
                    $car->setFifthImage('Default/defaultImage5.jpg');
                    $result['code'] = 200;
                }
    
                $em->persist($car);
                $em->flush();
            }
        }
        return new JsonResponse($result);
    }
}
