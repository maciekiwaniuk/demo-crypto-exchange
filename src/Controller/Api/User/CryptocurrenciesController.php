<?php

namespace App\Controller\Api\User;

use App\Config\Order as OrderConfig;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user/crypto', name: 'api.user.crypto.')]
class CryptocurrenciesController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route('/total-owned-crypto', name: 'total-owned-crypto')]
    public function getTotalOwnedCrypto(OrderRepository $orderRepository): Response
    {
        $transactions = $orderRepository->findBy(
            [
                'user' => $this->getUser(),
                'status' => OrderConfig::COMPLETED
            ]
        );

        $totaledCrypto = [];

        foreach ($transactions as $transaction) {

            $cryptoBought = $transaction->getCryptoToBuy();
            if ($cryptoBought) {
                $cryptoBoughtSymbol = $cryptoBought->getSymbol();
                if (! array_key_exists($cryptoBoughtSymbol, $totaledCrypto)) {
                    $totaledCrypto[$cryptoBoughtSymbol] = 0;
                }
            }

            $cryptoSold = $transaction->getCryptoToSell();
            if ($cryptoSold) {
                $cryptoSoldSymbol = $cryptoSold->getSymbol();
            }

            if ($transaction->getType() === OrderConfig::BUY_FOR_MONEY) {
                $totaledCrypto[$cryptoBoughtSymbol] += $transaction->getAmountOfCryptoToBuy();

            } else if ($transaction->getType() === OrderConfig::SELL_FOR_MONEY) {
                $totaledCrypto[$cryptoSoldSymbol] -= $transaction->getAmountOfCryptoToSell();

            } else if ($transaction->getType() === OrderConfig::EXCHANGE_BETWEEN_CRYPTOS) {
                $totaledCrypto[$cryptoBoughtSymbol] += $transaction->getAmountOfCryptoToBuy();
                $totaledCrypto[$cryptoSoldSymbol] -= $transaction->getAmountOfCryptoToSell();
            }
        }

        return $this->json([
            'cryptos' => $this->serializer->serialize($totaledCrypto, 'json')
        ]);
    }
}