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
     * @Route("/select/model", name="select_model")
     */
    public function selectModel(
        Request $request,
        BrandsRepository $repoBrand,
        ModelsRepository $repoModel, 
        EntityManagerInterface $em): Response
    {
        $brandName = $request->query->get('brand');
        $brand = $repoBrand->findOneBy(['brandName' => $brandName]);

        (!$brand) ? $models = $repoModel->findAll() : $models = $brand->getModels();

        $response = [];
        foreach ($models as $model) {
            $responseObj = [
                'name' => "model",
                'value' => $model->getModelName(),
                'label' => $model->getModelName(),
            ];
            $response[] = $responseObj;
        }
        return $this->json($response);
    }

    /**
     * @Route("/select/brand", name="select_brand")
     */
    public function selectBrand(
        Request $request,
        BrandsRepository $repoBrand,
        ModelsRepository $repoModel, 
        EntityManagerInterface $em): Response
    {
        $modelName = $request->query->get('model');
        $model = $repoModel->findOneBy(['modelName' => $modelName]);

        if (!$model) {
            $brands = $repoBrand->findAll();
            $response = [];

            foreach ($brands as $brand) {
                $responseObj = [
                    'name' => "brand",
                    'value' => $brand->getBrandName(),
                    'label' => $brand->getBrandName(),
                ];
                $response[] = $responseObj;
            }
        } else {
            $brand = $model->getBrand();
            $brandName = $brand->getBrandName();

            $response = [
                'name' => "brand",
                'value' => $brandName,
                'label' => $brandName,
            ];
        }
        return $this->json($response);
    }
}
