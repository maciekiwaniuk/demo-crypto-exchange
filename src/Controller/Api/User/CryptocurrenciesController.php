<?php

namespace App\Controller\Api\User;

use App\Config\Transaction as TransactionConfig;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user', name: 'api.user.')]
class CryptocurrenciesController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/total-owned-crypto', name: 'total-owned-crypto')]
    public function getTotalOwnedCrypto(TransactionRepository $transactionRepository): Response
    {
        $transactions = $transactionRepository->findBy(['user' => $this->getUser()]);

        $totaledCrypto = [];

        foreach ($transactions as $transaction) {

            $cryptoBought = $transaction->getCryptoBought();
            if ($cryptoBought) {
                $cryptoBoughtSymbol = $cryptoBought->getSymbol();
                if (! array_key_exists($cryptoBoughtSymbol, $totaledCrypto)) {
                    $totaledCrypto[$cryptoBoughtSymbol] = 0;
                }
            }

            $cryptoSold = $transaction->getCryptoSold();
            if ($cryptoSold) {
                $cryptoSoldSymbol = $cryptoSold->getSymbol();
            }

            if ($transaction->getType() === TransactionConfig::BOUGHT_FOR_MONEY) {
                $totaledCrypto[$cryptoBoughtSymbol] += $transaction->getNumberOfCryptoBought();

            } else if ($transaction->getType() === TransactionConfig::SOLD_FOR_MONEY) {
                $totaledCrypto[$cryptoSoldSymbol] -= $transaction->getNumberOfCryptoSold();

            } else if ($transaction->getType() === TransactionConfig::EXCHANGE_BETWEEN_CRYPTOS) {
                $totaledCrypto[$cryptoBoughtSymbol] += $transaction->getNumberOfCryptoBought();
                $totaledCrypto[$cryptoSoldSymbol] -= $transaction->getNumberOfCryptoSold();
            }
        }

        return $this->json([
            'cryptos' => $this->serializer->serialize($totaledCrypto, 'json')
        ]);
    }
}