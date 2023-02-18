<?php

namespace App\Controller\Api\User;

use App\Entity\Order;
use App\Config\Order as OrderConfig;
use App\Message\BuyOrder;
use App\Repository\CryptocurrencyRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

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
     *
     * @return Response
     */
    #[Route('/new-buy-order', name: 'new-buy-order', methods: ['POST'])]
    public function newBuyOrder(
        Request $request,
        MessageBusInterface $bus,
        CryptocurrencyRepository $cryptocurrencyRepository,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
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
            ->setStatus(OrderConfig::PENDING)
            ->setDoneAt(new \DateTimeImmutable())
            ->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($order);
        $entityManager->flush();

        $orderId = $order->getId();
        $bus->dispatch(new BuyOrder($orderId));

        return $this->json([
            'success' => true
        ]);
    }

    public function newSellOrder(
        Request $request,
        MessageBusInterface $bus,
        OrderRepository $orderRepository
    ): Response {

        return $this->json([
            'success' => true
        ]);
    }
}