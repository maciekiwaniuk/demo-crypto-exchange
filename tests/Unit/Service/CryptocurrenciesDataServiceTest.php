<?php

namespace App\Tests\Unit\Service;

use App\Entity\Cryptocurrency;
use App\HttpClient\BinanceApiHttpClient;
use App\Repository\CryptocurrencyRepository;
use App\Service\CryptocurrenciesDataService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CryptocurrenciesDataServiceTest extends KernelTestCase
{
    public function setUp(): void
    {
        $this->binanceApiHttpClient = $this->createMock(BinanceApiHttpClient::class);
        $this->cryptoRepository = $this->createMock(CryptocurrencyRepository::class);
    }

    public function testGetActiveCryptoDataWithoutErrors(): void
    {
        $activeCrypto = new Cryptocurrency();
        $activeCrypto
            ->setStatus('testStatus')
            ->setSymbol('testSymbol');
        $this->cryptoRepository
            ->expects($this->once())
            ->method('findBy')
            ->willReturn([$activeCrypto]);

        $responseFromApi = [];
        $this->binanceApiHttpClient
            ->expects($this->once())
            ->method('fetchCurrentPricesOfPassedCryptoSymbols')
            ->willReturn($responseFromApi);

        $cryptoDataService = new CryptocurrenciesDataService(
            $this->binanceApiHttpClient,
            $this->cryptoRepository
        );

        $cryptoDataService->getActiveCryptoData();
    }
}