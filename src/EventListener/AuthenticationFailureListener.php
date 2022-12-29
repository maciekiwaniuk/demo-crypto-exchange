<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener('lexik_jwt_authentication.on_authentication_failure')]
final class AuthenticationFailureListener
{
    public function __construct(public LoggerInterface $logger)
    {
    }

    public function __invoke(AuthenticationFailureEvent $event): void
    {
        $response = $event->getResponse();

        $content = json_decode($response->getContent(), true);
        $content['success'] = false;

        $response->setContent(json_encode($content));

        $event->setResponse($response);
    }
}