<?php

namespace App\HttpClient;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BinanceApiHttpClient
{
    const URL = 'https://api.binance.com/api/v3';

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client, public LoggerInterface $logger)
    {
        $this->client = $client;
    }

    public function fetchCurrentPriceOfPassedCryptoSymbol(string $cryptoSymbol): float
    {
        $param = 'symbol= '. $cryptoSymbol . 'USDT';
        $url = self::URL . '/ticker/price?' . $param;

        $this->logger->debug('CRUPTO SYMBOL', [$url]);

        $response = $this->client->request('GET', 'https://api.binance.com/api/v3/ticker/price?symbol=ETHUSDT');

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