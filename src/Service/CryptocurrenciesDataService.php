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

    private array $activeCryptos = [];

    public function __construct(
        EntityManagerInterface $entityManager,
        BinanceApiHttpClient $binanceApiHttpClient
    ) {
        $this->entityManager = $entityManager;
        $this->binanceApiHttpClient = $binanceApiHttpClient;

        $this->activeCryptos = $this->entityManager
            ->getRepository(Cryptocurrency::class)
            ->findBy(['active' => CryptocurrencyConfig::ACTIVE]);
    }

    public function getActiveCryptoData(): array
    {
        $symbols = [];
        foreach ($this->activeCryptos as $crypto) {
            $symbols[] = $crypto->getSymbol() . 'USDT';
        }

        return $this->binanceApiHttpClient
            ->fetchCurrentPricesOfPassedCryptoSymbols($symbols);
    }
}