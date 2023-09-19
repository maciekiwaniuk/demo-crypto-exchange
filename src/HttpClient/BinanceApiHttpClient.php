<?php

namespace App\HttpClient;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class BinanceApiHttpClient
{
    const URL = 'https://api.binance.com/api/v3';

    public function __construct(
        protected readonly HttpClientInterface $client
    ) {
    }

    public function fetchCurrentPriceOfPassedCryptoSymbol(string $cryptoSymbol): float
    {
        $param = 'symbol='. $cryptoSymbol . 'USDT';
        $url = self::URL . '/ticker/price?' . $param;

        $response = $this->client->request('GET', $url);

        return $response->toArray()['price'];
    }

    public function fetchCurrentPricesOfPassedCryptoSymbols(array $cryptoSymbols): array
    {
        $params = 'symbols=' . urlencode(json_encode($cryptoSymbols));
        $url = self::URL . '/ticker/price?' . $params;

        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }
}