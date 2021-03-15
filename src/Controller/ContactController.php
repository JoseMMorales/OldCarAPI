<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UsersRepository;
use App\Entity\Users;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact/{location}/{id}", name="contact")
     */
    public function contact(
        int $id, 
        Request $request, 
        string $location, 
        UsersRepository $repoUsers,
        \Swift_Mailer $mailer): Response
    {

        $contactName = $request->get('username');
        $contactEmail = $request->get('email');
        $contactText = $request->get('text');

        $contactForm= [
            'username' => $contactName,
            'email' => $contactEmail,
            'text' => $contactText
        ];

        $toEmail = '';

        if($id === 0){
            $toEmail = 'oldcarcodespace@gmail.com';
        } else {
            $user = $repoUsers->findOneBy(['id' => $id]);
            $userEmail = $user->getEmail();
            $toEmail = $userEmail;
        }

        $toLocation = '';
        $fromLocation = '';

        if ($location === 'contacts') {
            $fromLocation = $contactForm['email'];
            $toLocation = $toEmail;
        } else {
            $fromLocation = $contactForm['email'];
            $toLocation = $toEmail;
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
