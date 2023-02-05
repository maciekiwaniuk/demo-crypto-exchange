<?php

namespace App\Controller\Api\User;

use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user', name: 'api.user.')]
class TransactionsController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        public LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    #[Route('/transactions', name: 'transactions', methods: ['GET'])]
    public function getList(): Response
    {
        $transactions = $this->entityManager
            ->getRepository(Transaction::class)
            ->findBy(['id' => $this->getUser()->getId()]);

        return $this->json([
            'transactions' => $this->serializer->serialize($transactions, 'json')
        ]);
    }
}