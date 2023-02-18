<?php

namespace App\MessageHandler;

use App\Config\Order as OrderConfig;
use App\Message\BuyOrder;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Service\CryptocurrenciesDataService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class BuyOrderHandler
{
    private CryptocurrenciesDataService $cryptoDataService;
    private OrderRepository $orderRepository;
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        CryptocurrenciesDataService $cryptoDataService,
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        public LoggerInterface $logger
    ) {
        $this->cryptoDataService = $cryptoDataService;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(BuyOrder $buyOrder): void
    {
        $order = $this->orderRepository->find($buyOrder->getOrderId());
        $order->increaseAttempts();

        if ($order->getAttempts() >= OrderConfig::MAX_ATTEMPTS) {
            $order->setStatus(OrderConfig::TOO_MANY_ATTEMPTS);
            $this->entityManager->persist($order);
            $this->entityManager->flush();

            throw new \Exception('Too many attempts for buy order');
        }

        $symbol = $order->getCryptoToBuy()->getSymbol();
        $fetchedPrice = $this->cryptoDataService->fetchPriceBySymbol($symbol);
        $totalOrderValue = $order->getValue();
        $amountOfCryptoToBuy = $order->getAmountOfCryptoToBuy();

        $orderPrice = $totalOrderValue / $amountOfCryptoToBuy;

        $user = $this->userRepository->find($order->getUser()->getId());
        $balance = $user->getBalance();

        if ($orderPrice >= $fetchedPrice && $balance >= $totalOrderValue) {
            $balance -= $totalOrderValue;
            $user->setBalance($balance);

            $order->setStatus(OrderConfig::COMPLETED);

            $success = true;
        }

        $this->entityManager->persist($order);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        if (! isset($success)) {
            throw new \Exception('Buy order failed');
        }
    }
}