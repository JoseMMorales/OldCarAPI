<?php

// /src/AppBundle/Event/Listener/JWTCreatedListener.php

namespace App\Event;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    /**
     * Replaces the data in the generated
     *
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var $users \AppBundle\Entity\User */
        $user = $event->getUser();

        // add new data
        $payload['userId'] = $user->userId();
        $payload['username'] = $user->getUsername();

        $event->setData($payload);
    }
}