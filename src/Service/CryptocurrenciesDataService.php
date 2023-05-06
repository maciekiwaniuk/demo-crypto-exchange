<?php

namespace App\Service;

use App\Config\Cryptocurrency as CryptocurrencyConfig;
use App\Entity\Cryptocurrency;
use App\HttpClient\BinanceApiHttpClient;
use App\Repository\CryptocurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class CryptocurrenciesDataService
{
    public function __construct(
        private readonly BinanceApiHttpClient $binanceApiHttpClient,
        private readonly CryptocurrencyRepository $cryptoRepository
    ) {
    }

    public function getActiveCryptoData(): array
    {
        $activeCryptos = $this->cryptoRepository
            ->findBy(['status' => CryptocurrencyConfig::ACTIVE]);

        $symbols = [];
        foreach ($activeCryptos as $crypto) {
            $symbols[] = $crypto->getSymbol() . 'USDT';
        }

        if (count($symbols) == 0) return [];

        $cryptoData = $this->binanceApiHttpClient
            ->fetchCurrentPricesOfPassedCryptoSymbols($symbols);

        foreach ($cryptoData as &$crypto) {
            $symbol = $crypto['symbol'];
            $crypto['symbol'] = str_replace('USDT', '', $symbol);
        }

        return $cryptoData;
    }

    public function fetchPriceBySymbol(string $symbol): float
    {
        return $this->binanceApiHttpClient
            ->fetchCurrentPriceOfPassedCryptoSymbol($symbol);
    }
}