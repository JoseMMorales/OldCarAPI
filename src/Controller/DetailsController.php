<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class DetailsController extends AbstractController
{
    /**
     * @Route("/details/{id}", name="details", methods={"GET"})
     */
    public function detailsCars(int $id, EntityManagerInterface $em) : Response
    {
        $imageURL = "http://localhost:8000/img/";
        
        $response = $em->createQuery(
                        "SELECT 
                            c.carId as id,
                            c.carYear as year, 
                            c.km as km,
                            c.shortDescription as description,
                            c.longDescription as sellerDescription,
                            c.carPrice as price,
                            m.modelName as model, 
                            b.brandName as brand,
                            CONCAT('$imageURL' , c.mainImage) as mainImage,
                            CONCAT('$imageURL' , c.secondImage) as secondImage,
                            CONCAT('$imageURL' , c.thirdImage) as thirdImage,
                            CONCAT('$imageURL' , c.fourthImage) as fourthImage,
                            CONCAT('$imageURL' , c.fifthImage) as fifthImage,
                            u.username as sellerName,
                            u.userAddress as sellerAddress,
                            u.userPhone as sellerPhone,
                            u.userEmail as sellerEmail,
                            u.userType as seller
                        FROM App:Cars c 
                        JOIN App:Users u WITH c.user = u.userId
                        JOIN App:Models m WITH c.model = m.id
                        JOIN App:Brands b WITH m.brand = b.id
                        WHERE c.carId = '$id'")
                        
                        ->getResult();

        return new JsonResponse($response);
    }
}
