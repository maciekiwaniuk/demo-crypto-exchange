<?php

namespace App\Controller\Api\Auth;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationController extends AbstractController
{
    #[Route('/api/check-login', name: 'api.check-login', methods: ['POST'])]
    public function checkLogin(Request $request, LoggerInterface $logger): Response
    {
        $user = $this->getUser();

        if (! $user instanceof UserInterface) {
            throw $this->createAccessDeniedException();
        }

        $request->getSession()->set(Security::LAST_USERNAME, $user->getUsername());

        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);
    }
}