<?php

namespace App\Controller\Api\User;

use App\Entity\Order;
use App\Config\Order as OrderConfig;
use App\Message\BuyOrder;
use App\Message\SellOrder;
use App\Repository\CryptocurrencyRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user/market', name: 'api.user.market.')]
class MarketController extends AbstractController
{
    /**
     * @param Request $request
     * @var string $cryptoToBuySymbol
     * @var float $amountOfCryptoToBuy
     * @var float $value
     *
     * @param MessageBusInterface $bus
     * @param CryptocurrencyRepository $cryptocurrencyRepository
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    #[Route('/new-buy-order', name: 'new-buy-order', methods: ['POST'])]
    public function newBuyOrder(
        Request $request,
        MessageBusInterface $bus,
        CryptocurrencyRepository $cryptocurrencyRepository,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ): Response {
        $data = json_decode($request->getContent(), true);

        $order = new Order();

        $cryptoSymbol = str_replace('USDT', '', $data['cryptoToBuySymbol']);
        $crypto = $cryptocurrencyRepository->findOneBy(['symbol' => $cryptoSymbol]);

        $order->setUser($this->getUser())
            ->setCryptoToBuy($crypto)
            ->setAmountOfCryptoToBuy($data['amountOfCryptoToBuy'])
            ->setValue($data['value'])
            ->setType(OrderConfig::BUY_FOR_MONEY)
            ->setStatus(OrderConfig::PENDING);

        $entityManager->persist($order);
        $entityManager->flush();

        $orderId = $order->getId();
        $bus->dispatch(new BuyOrder($orderId));

        return $this->json([
            'success' => true,
            'order' => $serializer->serialize($order, 'json')
        ]);
    }

    /**
     * @param Request $request
     * @var string $cryptoToSellSymbol
     * @var float $amountOfCryptoToSell
     * @var float $value
     *
     * @param MessageBusInterface $bus
     * @param CryptocurrencyRepository $cryptocurrencyRepository
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    #[Route('/new-sell-order', name: 'new-sell-order', methods: ['POST'])]
    public function newSellOrder(
        Request $request,
        MessageBusInterface $bus,
        CryptocurrencyRepository $cryptocurrencyRepository,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ): Response {
        $data = json_decode($request->getContent(), true);

        $order = new Order();

        $cryptoSymbol = str_replace('USDT', '', $data['cryptoToSellSymbol']);
        $crypto = $cryptocurrencyRepository->findOneBy(['symbol' => $cryptoSymbol]);

        $order->setUser($this->getUser())
            ->setCryptoToSell($crypto)
            ->setAmountOfCryptoToSell($data['amountOfCryptoToSell'])
            ->setValue($data['value'])
            ->setType(OrderConfig::SELL_FOR_MONEY)
            ->setStatus(OrderConfig::PENDING);

        $entityManager->persist($order);
        $entityManager->flush();

        $orderId = $order->getId();
        $bus->dispatch(new SellOrder($orderId));

        return $this->json([
            'success' => true,
            'order' => $serializer->serialize($order, 'json')
        ]);
    }

    #[Route('/get-orders', name: 'get-orders', methods: ['GET'])]
    public function getOrders(OrderRepository $orderRepository, SerializerInterface $serializer): Response
    {
        $orders = $orderRepository->findBy(
            [
                'user' => $this->getUser(),
                'type' => [OrderConfig::BUY_FOR_MONEY, OrderConfig::SELL_FOR_MONEY]
            ]
        );

        return $this->json([
            'orders' => $serializer->serialize($orders, 'json')
        ]);
    }
}