<?php

namespace App\Tests\Entity;

use App\Config\Cryptocurrency as CryptocurrencyConfig;
use App\Entity\Cryptocurrency;
use PHPUnit\Framework\TestCase;

class CryptocurrencyTest extends TestCase
{
    public function testCreatingInstance(): void
    {
        $symbol = 'BTC';

        $crypto = new Cryptocurrency();

        $crypto->setSymbol($symbol)
            ->setStatus(CryptocurrencyConfig::ACTIVE);

        $this->assertSame($symbol, $crypto->getSymbol());
        $this->assertSame(CryptocurrencyConfig::ACTIVE, $crypto->getStatus());
        $this->assertNotEmpty($crypto->getCreatedAt());
        $this->assertNotEmpty($crypto->getUpdatedAt());
    }
}