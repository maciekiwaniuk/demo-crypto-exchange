<?php

namespace App\Controller\Api\General;

use App\Entity\Cryptocurrency;
use App\Config\Cryptocurrency as CryptocurrencyConfig;
use App\HttpClient\BinanceApiHttpClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api.')]
class CryptocurrenciesController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private BinanceApiHttpClient $binanceApiHttpClient;

    public function __construct(
        EntityManagerInterface $entityManager,
        BinanceApiHttpClient $binanceApiHttpClient,
        public LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->binanceApiHttpClient = $binanceApiHttpClient;
    }

    #[Route('/get_prices_of_active_cryptos', name: 'get_prices_of_active_cryptos', methods: ['GET'])]
    public function getPricesOfActiveCryptos(): Response
    {
        $activeCryptos = $this->entityManager
            ->getRepository(Cryptocurrency::class)
            ->findBy(['active' => CryptocurrencyConfig::ACTIVE]);

        $symbols = [];
        foreach ($activeCryptos as $crypto) {
            $symbols[] = $crypto->getSymbol() . 'USDT';
        }

        $cryptos = $this->binanceApiHttpClient
            ->fetchCurrentPricesOfPassedCryptoSymbols($symbols);

        return $this->json([
           'cryptos' => $cryptos
        ]);
    }
}