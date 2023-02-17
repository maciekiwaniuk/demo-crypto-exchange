<?php

namespace App\MessageHandler;

use App\Config\Order as OrderConfig;
use App\Message\PurchaseOrder;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Service\CryptocurrenciesDataService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class PurchaseOrderHandler
{
    private CryptocurrenciesDataService $cryptoDataService;
    private OrderRepository $orderRepository;
    private UserRepository $userRepository;

    public function __construct(
        CryptocurrenciesDataService $cryptoDataService,
        OrderRepository $orderRepository,
        UserRepository $userRepository
    ) {
        $this->cryptoDataService = $cryptoDataService;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(
        PurchaseOrder $purchaseOrder
    ): void {
        $order = $this->orderRepository->find($purchaseOrder->getOrderId());

        $symbol = $order->getCryptoToBuy()->getSymbol();
        $fetchedPrice = $this->cryptoDataService->fetchPriceBySymbol($symbol);
        $totalOrderValue = $order->getValue();
        $amountOfCryptoToBuy = $order->getAmountOfCryptoToBuy();

        $orderPrice = $totalOrderValue / $amountOfCryptoToBuy;

        if ($fetchedPrice >= $orderPrice) {
            $user = $this->userRepository->find($order->getUser()->getId());
            $balance = $user->getBalance();

            if ($balance >= $totalOrderValue) {
                $balance -= $totalOrderValue;
                $user->setBalance($balance);

                $order->setStatus(OrderConfig::COMPLETED);
                return;
            }
        }

        throw new \Exception();
    }
}