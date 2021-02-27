<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FillDBController extends AbstractController
{
    /**
     * @Route("/fill/d/b", name="fill_d_b")
     */
    public function index(): Response
    {
        return $this->render('fill_db/index.html.twig', [
            'controller_name' => 'FillDBController',
        ]);
    }
}
