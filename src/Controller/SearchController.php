<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/{brands}/{models}/{kms}/{years}/{sellers}/{price}", name="searchCar")
     * @Method({"GET"})
     */
    public function search( string $brands= '', string $models= '', int $kms= null, 
                            int $years= null, string $sellers= '', int $price= null ): Response
    {   

        $result = [
                    "brand"=>"$brands", 
                    "model"=>"$models",
                    "km"=>"$kms",
                    "years"=>"$years",
                    "seller"=>"$sellers",
                    "price"=>"$price"
                ];

        $resultJson = json_encode($result, JSON_PRETTY_PRINT);

        return new Response($resultJson);
    }
}
