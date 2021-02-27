<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FillDBController extends AbstractController
{
    /**
     * @Route("/fill", name="fill")
     */
    public function index(): Response
    {

        $message = 'Hello OldCar DB';
        return $this->render('fill_db/index.html.twig', [
            'controller_name' => $message,
        ]);
    }
}
