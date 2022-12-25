<?php

namespace App\Controller\Api\Auth;

use App\Dto\Api\UserRegistrationDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @param UserRegistrationDto $dto
     * @param UserPasswordHasherInterface $passwordHasher
     * @param EntityManagerInterface $entityManager
     * @param JWTTokenManagerInterface $JWTManager
     * @return Response
     */
    #[Route('/api/register', name: 'api.register', methods: ['POST'])]
    public function register(
        UserRegistrationDto $dto,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface $JWTManager
    ): Response {

        if ($dto->hasErrors()) {
            return $this->json([
                'success' => false,
                'errors' => $dto->getErrors()
            ]);
        }

        $user = new User();
        $user->setUsername($dto->username);
        $user->setEmail($dto->email);

        $hashedPassword = $passwordHasher->hashPassword($user, $dto->password);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        $token = $JWTManager->create($user);

        return $this->json([
            'success' => true,
            'token' => $token
        ]);
    }
}