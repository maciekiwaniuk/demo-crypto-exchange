<?php

namespace App\Controller\Api\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user', name: 'api.user.')]
class UserController extends AbstractController
{
    #[Route('/data', name: 'data', methods: ['GET'])]
    public function getUserData(): Response
    {
        $user = $this->getUser();

        $userData = new \stdClass();
        $userData->balance = $user->getBalance();
        $userData->lastLoginTime = $user->getLastLoginTime();
        $userData->lastLoginIp = $user->getLastLoginIp();
        $userData->isVerified = $user->isVerified();
        $userData->banStatus = $user->getBanStatus();

        return $this->json([
            'userData' => $userData
        ]);
    }

}