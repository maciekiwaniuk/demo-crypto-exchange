<?php

namespace App\Controller\Api\User;

use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user/transactions', name: 'api.user.transactions.')]
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

    #[Route('/list', name: 'list', methods: ['GET'])]
    public function getList(): Response
    {
        $transactions = $this->entityManager
            ->getRepository(Transaction::class)
            ->findBy(['id' => $this->getUser()->getId()]);

        return $this->json([
            'transactions' => $this->serializer->serialize($transactions, 'json')
        ]);
    }

    /**
     * @param Request $request
     * @var string $type
     * @var ?string $cryptoSoldSymbol
     * @var ?string $cryptoBoughtSymbol
     * @var ?float $numberOfCryptoSold
     * @var ?float $numberOfCryptoBought
     * @var ?float $value
     *
     * @return Response
     */
    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request): Response
    {


        return $this->json([

        ]);
    }
}