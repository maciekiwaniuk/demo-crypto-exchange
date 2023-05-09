<?php

namespace App\Tests\Application\HttpClient;

use App\HttpClient\BinanceApiHttpClient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BinanceApiHttpClientTest extends WebTestCase
{
    protected function setUp(): void
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $this->binanceApiHttpClient = $container->get(BinanceApiHttpClient::class);
    }

    public function testFetchCurrentPriceOfPassedCryptoSymbol(): void
    {
        $price = $this->binanceApiHttpClient
            ->fetchCurrentPriceOfPassedCryptoSymbol('BTC');

        $this->assertIsFloat($price);
    }

    public function testFetchCurrentPricesOfPassedCryptoSymbols(): void
    {
        $prices = $this->binanceApiHttpClient
            ->fetchCurrentPricesOfPassedCryptoSymbols(['BTCUSDT', 'DOGEUSDT']);

        $this->assertIsArray($prices);
    }
}