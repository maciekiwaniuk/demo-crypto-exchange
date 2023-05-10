<?php

namespace App\Controller\Api\User;

use App\Config\Order as OrderConfig;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user/transaction-history', name: 'api.user.transaction-history.')]
class TransactionHistoryController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    #[Route('/get-list', name: 'get-list', methods: ['GET'])]
    public function getList(OrderRepository $orderRepository): Response
    {
        $transactionHistory = $orderRepository
            ->findBy(
                [
                    'user'   => $this->getUser(),
                    'status' => OrderConfig::COMPLETED
                ]
            );

        return $this->json([
            'transactionHistory' => $this->serializer->serialize($transactionHistory, 'json')
        ]);
    }
}