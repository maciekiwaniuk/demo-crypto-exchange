<?php

namespace App\Controller\Api\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user', name: 'api.')]
class SettingsController extends AbstractController
{
    #[Route('/change_passowrd', name: 'change_password', methods: ['POST'])]
    public function changePassword(): Response
    {
        // error with entry authentication point
        return $this->json([
            'success' => true,
        ]);
    }
}