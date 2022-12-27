<?php

namespace App\EventListener;

use App\Config\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener('lexik_jwt_authentication.on_authentication_success')]
final class AuthenticationSuccessListener
{
    public function __invoke(AuthenticationSuccessEvent $event): void
    {
        $user = $event->getUser();
        $token = $event->getData()['token'];
        $roles = $user->getRoles();
        $userIdentifier = $user->getUserIdentifier();

        $finalData = [
            'token' => $token,
            'roles' => $roles,
            User::IDENTIFIER_FIELD => $userIdentifier
        ];

        $event->setData($finalData);
    }
}