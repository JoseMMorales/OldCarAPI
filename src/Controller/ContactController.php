<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact/{location}", name="contact")
     */
    public function contact(string $location, Request $request, \Swift_Mailer $mailer): Response
    {
        $contactName = $request->get('username');
        $contactEmail = $request->get('email');
        $contactText = $request->get('text');

        $contactForm= [
            'username' => $contactName,
            'email' => $contactEmail,
            'text' => $contactText
        ];

        $toLocation = '';
        $fromLocation = '';

        if ($location === 'contacts') {
            $fromLocation = $contactForm['email'];
            $toLocation = 'oldcarcodespace@gmail.com';
        } else {
            $fromLocation = 'oldcarcodespace@gmail.com';
            $toLocation = $contactForm['email'];
        };
        
        $message = (new \Swift_Message('Email recibido desde OldCar'))
            ->setFrom($fromLocation)
            ->setTo($toLocation)
            ->setBody(
                $this->renderView(
                    'emails/email.html.twig',[
                    'name' => $contactForm['username'],
                    'email' => $contactForm['email'],
                    'text' => $contactForm['text']
                ]),
                'text/html'
        );

        $mailer->send($message);

        $response = "Email Sent!";

        return $this->json($response);
    }
}
