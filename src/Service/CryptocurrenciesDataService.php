<?php

namespace App\Service;

use App\Config\Cryptocurrency as CryptocurrencyConfig;
use App\Entity\Cryptocurrency;
use App\HttpClient\BinanceApiHttpClient;
use Doctrine\ORM\EntityManagerInterface;

class CryptocurrenciesDataService
{
    private EntityManagerInterface $entityManager;
    private BinanceApiHttpClient $binanceApiHttpClient;

    public function __construct(
        EntityManagerInterface $entityManager,
        BinanceApiHttpClient $binanceApiHttpClient
    ) {
        $this->entityManager = $entityManager;
        $this->binanceApiHttpClient = $binanceApiHttpClient;


    }

    public function getActiveCryptoData(): array
    {
        $activeCryptos = $this->entityManager
            ->getRepository(Cryptocurrency::class)
            ->findBy(['active' => CryptocurrencyConfig::ACTIVE]);

        $symbols = [];
        foreach ($activeCryptos as $crypto) {
            $symbols[] = $crypto->getSymbol() . 'USDT';
        }

        if (count($symbols) == 0) return [];

        return $this->binanceApiHttpClient
            ->fetchCurrentPricesOfPassedCryptoSymbols($symbols);
    }

    public function fetchPriceBySymbol(string $symbol): float
    {
        return $this->binanceApiHttpClient
            ->fetchCurrentPriceOfPassedCryptoSymbol($symbol);
    }
}