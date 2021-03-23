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
        $brand = $repoBrand->findOneBy(['brandName' => $brandName]);

        $models = $brand->getModels();

        $response = [];

        foreach ($models as $model) {
            $responseObj = [
                'value' => $model->getModelName(),
                'label' => $model->getModelName(),
            ];

            $response[] = $responseObj;
        }
        
        return $this->json($response);
    }
}
