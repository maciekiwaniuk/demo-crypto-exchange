<?php

namespace App\HttpClient;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class BinanceApiHttpClient
{
    private HttpClientInterface $client;

    const URL = 'https://api.binance.com/api/v3';

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchCurrentPricesOfPassedCryptoSymbols(array $cryptoSymbols): array
    {
        $params = 'symbols=' . urlencode(json_encode($cryptoSymbols));
        $url = self::URL . '/ticker/price?' . $params;

        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }
}