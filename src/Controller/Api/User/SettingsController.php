<?php

namespace App\Controller\Api\User;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user', name: 'api.user.')]
class SettingsController extends AbstractController
{
    #[Route('/change_password', name: 'change_password', methods: ['POST'])]
    public function changePassword(LoggerInterface $logger): Response
    {
        $logger->debug("1", ["test"]);
        // error with entry authentication point
        return $this->json([
            'success' => true,
        ]);
    }
}