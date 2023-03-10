<?php

namespace App\Tests\Entity;

use App\Config\Order as OrderConfig;
use App\Entity\Order;
use App\Factory\CryptocurrencyFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class OrderTest extends KernelTestCase
{
    use ResetDatabase;

    public function testCreatingInstance(): void
    {
        $container = self::getContainer();

        $userFactory = $container->get(UserFactory::class);
        $user = $userFactory->createOne()->object();

        $cryptoFactory = $container->get(CryptocurrencyFactory::class);
        $crypto = $cryptoFactory->createOne()->object();

        $amountOfCryptoToBuy = mt_rand(1, 10);
        $price = mt_rand(100, 100_000);
        $value = $amountOfCryptoToBuy * $price;
        $doneAt = new \DateTimeImmutable();

        $order = new Order();
        $order->setUser($user)
            ->setType(OrderConfig::BUY_FOR_MONEY)
            ->setStatus(OrderConfig::COMPLETED)
            ->setCryptoToBuy($crypto)
            ->setAmountOfCryptoToBuy($amountOfCryptoToBuy)
            ->setValue($value)
            ->setDoneAt($doneAt);

        $order->increaseAttempts();

        $this->assertSame(1, $order->getAttempts());
        $this->assertSame(OrderConfig::BUY_FOR_MONEY, $order->getType());
        $this->assertSame(OrderConfig::COMPLETED, $order->getStatus());
        $this->assertSame($crypto, $order->getCryptoToBuy());
        $this->assertEquals($amountOfCryptoToBuy, $order->getAmountOfCryptoToBuy());
        $this->assertEquals($value, $order->getValue());
        $this->assertSame($doneAt, $order->getDoneAt());
        $this->assertNotEmpty($order->getCreatedAt());
    }
}