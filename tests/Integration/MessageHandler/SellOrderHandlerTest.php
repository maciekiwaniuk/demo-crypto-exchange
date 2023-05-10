<?php

namespace App\Tests\Integration\MessageHandler;

use App\Entity\Cryptocurrency;
use App\Entity\Order;
use App\Config\Order as OrderConfig;
use App\Entity\User;
use App\Exception\OrderFailedException;
use App\Exception\TooManyAttemptsOnOrderException;
use App\Message\SellOrder;
use App\MessageHandler\SellOrderHandler;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Service\CryptocurrenciesDataService;
use App\Tests\Tools\PrivateProperty;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SellOrderHandlerTest extends KernelTestCase
{
    protected CryptocurrenciesDataService $cryptoDataService;
    protected OrderRepository $orderRepository;
    protected UserRepository $userRepository;
    protected SellOrder $sellOrder;
    protected Order $order;
    protected User $user;

    protected function setUp(): void
    {
        $this->cryptoDataService = $this->createMock(CryptocurrenciesDataService::class);
        $this->orderRepository = $this->createMock(OrderRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);

        $this->sellOrder = new SellOrder(2023);
        $crypto = new Cryptocurrency();
        $crypto->setSymbol('BTC');

        $this->user = new User();
        PrivateProperty::set($this->user, 'id', 123);

        $this->order = new Order();
        $this->order
            ->setUser($this->user)
            ->setCryptoToSell($crypto);
    }

    public function testSuccessfulRunOfHandler(): void
    {
        $this->orderRepository
            ->expects($this->atLeastOnce())
            ->method('find')
            ->willReturn($this->order);

        $currentPriceOfCrypto = 100.0;
        $this->cryptoDataService
            ->expects($this->atLeastOnce())
            ->method('fetchPriceBySymbol')
            ->willReturn($currentPriceOfCrypto);

        $requestedPriceOfCrypto = 90;
        $requestAmountOfCrypto = 1;
        $this->order
            ->setValue($requestedPriceOfCrypto)
            ->setAmountOfCryptoToSell($requestAmountOfCrypto);

        $userBalance = 1000;
        $this->user->setBalance($userBalance);
        $this->userRepository
            ->expects($this->atLeastOnce())
            ->method('find')
            ->willReturn($this->user);

        $handler = new SellOrderHandler(
            $this->cryptoDataService,
            $this->orderRepository,
            $this->userRepository
        );

        $handler->__invoke($this->sellOrder);

        $finalProfit = $requestAmountOfCrypto * $requestedPriceOfCrypto;
        $balanceAfterTransaction = $userBalance + $finalProfit;
        $this->assertEquals($balanceAfterTransaction, $this->user->getBalance());
    }

    public function testFailingTooManyAttempts(): void
    {
        $this->order->setAttempts(OrderConfig::MAX_ATTEMPTS);

        $this->orderRepository
            ->expects($this->atLeastOnce())
            ->method('find')
            ->willReturn($this->order);

        $this->cryptoDataService
            ->expects($this->never())
            ->method($this->anything());

        $this->userRepository
            ->expects($this->never())
            ->method($this->anything());

        $handler = new SellOrderHandler(
            $this->cryptoDataService,
            $this->orderRepository,
            $this->userRepository
        );

        $this->expectException(TooManyAttemptsOnOrderException::class);

        $handler->__invoke($this->sellOrder);
    }

    public function testFailingSellPriceHigherThanFetchedPrice(): void
    {
        $this->orderRepository
            ->expects($this->atLeastOnce())
            ->method('find')
            ->willReturn($this->order);

        $currentPriceOfCrypto = 100.0;
        $this->cryptoDataService
            ->expects($this->atLeastOnce())
            ->method('fetchPriceBySymbol')
            ->willReturn($currentPriceOfCrypto);

        $requestedPriceOfCryptoToSell = 110;
        $this->order
            ->setValue($requestedPriceOfCryptoToSell)
            ->setAmountOfCryptoToSell(1);

        $this->user->setBalance(1000);
        $this->userRepository
            ->expects($this->atLeastOnce())
            ->method('find')
            ->willReturn($this->user);

        $handler = new SellOrderHandler(
            $this->cryptoDataService,
            $this->orderRepository,
            $this->userRepository
        );

        $this->expectException(OrderFailedException::class);

        $handler->__invoke($this->sellOrder);
    }
}