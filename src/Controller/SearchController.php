<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CarsRepository;
use Doctrine\ORM\EntityManagerInterface;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/{brand}/{model}", name="brands", methods={"GET"})
     */
    public function queryBuilder(string $brand, string $model = '', EntityManagerInterface $em) : Response
    {
        ($model) ? $modelSQL = "AND m.modelName = '$model'" : $modelSQL = '';

        $imageURL = "http://localhost:8000/img/";
        
        $response = $em->createQuery(
                        "SELECT 
                            c.carId as id,
                            c.carYear as year, 
                            c.km as km,
                            c.shortDescription as description,
                            c.carPrice as price,
                            CONCAT('http://localhost:8000/img/' , c.mainImage) as image,
                            m.modelName as model, 
                            b.brandName as brand,
                            u.userType as seller
                        FROM App:Cars c 
                        JOIN App:Users u WITH c.user = u.userId
                        JOIN App:Models m WITH c.model = m.id
                        JOIN App:Brands b WITH m.brand = b.id
                        WHERE b.brandName = '$brand'
                        $modelSQL")
                        
                        ->getResult();

                        return new JsonResponse($response);
    }
}
