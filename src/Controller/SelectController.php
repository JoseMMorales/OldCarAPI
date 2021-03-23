<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BrandsRepository;
use App\Repository\ModelsRepository;
use App\Entity\Models;
use App\Entity\Brands;

class SelectController extends AbstractController
{
    /**
     * @Route("/select", name="select")
     */
    public function select(
        Request $request,
        BrandsRepository $repoBrand,
        ModelsRepository $repoModel, 
        EntityManagerInterface $em): Response
    {
        $brandName = $request->query->get('brand');
        $brand = $repoBrand->findBy(['brandName' => $brandName]);

        $response = [
            'value' => $brand->getBrand(),
            'label' => $brand,
        ];

        // $response = $em->createQueryBuilder()
        //     ->select('model.modelName as label','model.modelName as value')
        //     ->from('App:Brands', 'brand')
        //     ->Join('brand.id', 'model')
        //     ->where('brand.brandName = :brand')
        //     ->setParameter('brand' , $brandName)
        //     ->getQuery()->getResult();
        
        return $this->json($response);
    }
}
