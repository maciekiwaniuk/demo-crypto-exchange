<?php

namespace App\MessageHandler;

use App\Config\Order as OrderConfig;
use App\Exception\OrderFailedException;
use App\Exception\TooManyAttemptsOnOrderException;
use App\Message\SellOrder;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Service\CryptocurrenciesDataService;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SellOrderHandler
{
    public function __construct(
        protected readonly CryptocurrenciesDataService $cryptoDataService,
        protected readonly OrderRepository $orderRepository,
        protected readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(SellOrder $sellOrder): void
    {
        $order = $this->orderRepository->find($sellOrder->getOrderId());
        $order->increaseAttempts();

        if ($order->getAttempts() >= OrderConfig::MAX_ATTEMPTS) {
            $order->setStatus(OrderConfig::TOO_MANY_ATTEMPTS);
            $order->setDoneAt(new DateTimeImmutable());
            $this->orderRepository->save($order, true);

            throw new TooManyAttemptsOnOrderException('Too many attempts for sell order');
        }

        $symbol = $order->getCryptoToSell()->getSymbol();
        $fetchedPrice = $this->cryptoDataService->fetchPriceBySymbol($symbol);
        $totalOrderValue = $order->getValue();
        $amountOfCryptoToSell = $order->getAmountOfCryptoToSell();

        $orderPrice = $totalOrderValue / $amountOfCryptoToSell;

        $user = $this->userRepository->find($order->getUser()->getId());
        $balance = $user->getBalance();

        if ($fetchedPrice >= $orderPrice) {
            $balance += $totalOrderValue;
            $user->setBalance($balance);

            $order->setStatus(OrderConfig::COMPLETED);
            $order->setDoneAt(new DateTimeImmutable());

            $success = true;
        }

        $this->orderRepository->save($order);
        $this->userRepository->save($user);

        if (! isset($success)) {
            throw new OrderFailedException('Sell order failed');
        }
    }
}