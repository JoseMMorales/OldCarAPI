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

        // $toLocation = '';
        // $fromLocation = '';

        // if ($location === 'contact') {
        //     $toLocation = 'oldcarcodespace@gmail.com';
        //     $fromLocation = $contactForm['email'];
        // } else {
        //     $toLocation = $contactForm['email'];
        //     $fromLocation = 'oldcarcodespace@gmail.com';
        // };
        
        $message = (new \Swift_Message('Tienes un email'))
            ->setFrom('oldcarcodespace@gmail.com')
            ->setTo('mistymossd48@vaticanakq.com')
            ->setBody(
                $contactForm['text']
        );

        $mailer->send($message);

        $response = "Email Sent!";

        return $this->json($response);
    }
}
