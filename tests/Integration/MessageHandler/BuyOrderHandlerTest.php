<?php

namespace App\Tests\Integration\MessageHandler;

use App\Entity\Cryptocurrency;
use App\Entity\Order;
use App\Entity\User;
use App\Config\User as UserConfig;
use App\Config\Order as OrderConfig;
use App\Exception\OrderFailedException;
use App\Exception\TooManyAttemptsOnOrderException;
use App\Message\BuyOrder;
use App\MessageHandler\BuyOrderHandler;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Service\CryptocurrenciesDataService;
use App\Tests\Tools\PrivateProperty;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BuyOrderHandlerTest extends KernelTestCase
{
    protected CryptocurrenciesDataService $cryptoDataService;
    protected OrderRepository $orderRepository;
    protected UserRepository $userRepository;
    protected BuyOrder $buyOrder;
    protected Order $order;
    protected User $user;

    protected function setUp(): void
    {
        $this->cryptoDataService = $this->createMock(CryptocurrenciesDataService::class);
        $this->orderRepository = $this->createMock(OrderRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);

        $this->buyOrder = new BuyOrder(2023);
        $crypto = new Cryptocurrency();
        $crypto->setSymbol('BTC');

        $this->user = new User();
        PrivateProperty::set($this->user, 'id', 123);

        $this->order = new Order();
        $this->order
            ->setUser($this->user)
            ->setCryptoToBuy($crypto);
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

        $requestedPriceOfCrypto = 110;
        $requestedAmountOfCrypto = 1;
        $this->order
            ->setValue($requestedPriceOfCrypto)
            ->setAmountOfCryptoToBuy($requestedAmountOfCrypto);

        $userBalance = 1000;
        $this->user->setBalance($userBalance);
        $this->userRepository
            ->expects($this->atLeastOnce())
            ->method('find')
            ->willReturn($this->user);

        $handler = new BuyOrderHandler(
            $this->cryptoDataService,
            $this->orderRepository,
            $this->userRepository
        );


        $handler->__invoke($this->buyOrder);

        $finalCost = $requestedAmountOfCrypto * $requestedPriceOfCrypto;
        $balanceAfterTransaction = $userBalance - $finalCost;
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

        $handler = new BuyOrderHandler(
            $this->cryptoDataService,
            $this->orderRepository,
            $this->userRepository
        );

        try {
            $handler->__invoke($this->buyOrder);
        } catch (TooManyAttemptsOnOrderException) {
            $this->assertTrue(true);
        }

        $this->assertEquals(UserConfig::DEFAULT_BALANCE, $this->user->getBalance());
    }

    public function testFailingInsufficientBalance(): void
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

        $requestedPriceOfCryptoToBuy = 110;
        $this->order
            ->setValue($requestedPriceOfCryptoToBuy)
            ->setAmountOfCryptoToBuy(1);

        $userBalance = 10;
        $this->user->setBalance($userBalance);
        $this->userRepository
            ->expects($this->atLeastOnce())
            ->method('find')
            ->willReturn($this->user);

        $handler = new BuyOrderHandler(
            $this->cryptoDataService,
            $this->orderRepository,
            $this->userRepository
        );

        try {
            $handler->__invoke($this->buyOrder);
        } catch (OrderFailedException) {
            $this->assertTrue(true);
        }

        $this->assertEquals($userBalance, $this->user->getBalance());
    }

    public function testFailingBuyPriceLowerThanFetchedPrice(): void
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

        $requestedPriceOfCryptoToBuy = 90;
        $this->order
            ->setValue($requestedPriceOfCryptoToBuy)
            ->setAmountOfCryptoToBuy(1);

        $userBalanace = 1000;
        $this->user->setBalance($userBalanace);
        $this->userRepository
            ->expects($this->atLeastOnce())
            ->method('find')
            ->willReturn($this->user);

        $handler = new BuyOrderHandler(
            $this->cryptoDataService,
            $this->orderRepository,
            $this->userRepository
        );

        try {
            $handler->__invoke($this->buyOrder);
        } catch (OrderFailedException) {
            $this->assertTrue(true);
        }

        $this->assertEquals($userBalanace, $this->user->getBalance());
    }
}