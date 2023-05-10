<?php

namespace App\MessageHandler;

use App\Config\Order as OrderConfig;
use App\Exception\OrderFailedException;
use App\Exception\TooManyAttemptsOnOrderException;
use App\Message\BuyOrder;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Service\CryptocurrenciesDataService;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class BuyOrderHandler
{
    public function __construct(
        private readonly CryptocurrenciesDataService $cryptoDataService,
        private readonly OrderRepository $orderRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(BuyOrder $buyOrder): void
    {
        $order = $this->orderRepository->find($buyOrder->getOrderId());
        $order->increaseAttempts();

        if ($order->getAttempts() >= OrderConfig::MAX_ATTEMPTS) {
            $order->setStatus(OrderConfig::TOO_MANY_ATTEMPTS);
            $order->setDoneAt(new DateTimeImmutable());
            $this->orderRepository->save($order, true);

            throw new TooManyAttemptsOnOrderException('Too many attempts for buy order');
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
            $order->setDoneAt(new DateTimeImmutable());

            $success = true;
        }

        $this->orderRepository->save($order, true);
        $this->userRepository->save($user, true);

        if (! isset($success)) {
            throw new OrderFailedException('Buy order failed');
        }
    }
}