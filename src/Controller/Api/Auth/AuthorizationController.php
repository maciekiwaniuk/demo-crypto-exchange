<?php

namespace App\Controller\Api\Auth;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorizationController extends AbstractController
{
    #[Route('/api/login', name: 'api.login', methods: ['POST'])]
    public function login(Request $request, LoggerInterface $logger): Response
    {
        $data = json_decode($request->getContent(), true);
        $logger->debug('test', [$data]);

        return $this->json([
            'callback' => 'testtttttttttt'
        ]);
    }

    #[Route('/api/logout', name: 'api.logout', methods: ['POST'])]
    public function logout(): Response
    {
        return $this->json(null, 204);
    }
}