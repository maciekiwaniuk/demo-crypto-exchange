<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class AuthenticationSuccessSubscriber implements EventSubscriberInterface
{
    private Request $request;

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $this->request = $event->getRequest();
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $user = $event->getUser();

        $ip = $this->request->getClientIp();
        $userAgent = $this->request->headers->get('User-Agent');
        $time = new \DateTime('now');
        $user->fillDataAfterSuccessfulAuthentication($ip, $userAgent, $time);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $token = $event->getData()['token'];
        $roles = $user->getRoles();
        $finalData = [
            'success' => true,
            'token' => $token,
            'roles' => $roles
        ];

        $event->setData($finalData);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
            Events::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccess',
        ];
    }
}
