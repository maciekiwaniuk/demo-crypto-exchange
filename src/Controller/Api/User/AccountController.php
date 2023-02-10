<?php

namespace App\Controller\Api\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user', name: 'api.user.')]
class AccountController extends AbstractController
{
    #[Route('/change-password', name: 'change-password', methods: ['POST'])]
    public function changePassword(): Response
    {
        return $this->json([
            'success' => true,
        ]);
    }
}