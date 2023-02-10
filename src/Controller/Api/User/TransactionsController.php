<?php

namespace App\Controller\Api\User;

use App\Entity\Cryptocurrency;
use App\Entity\Transaction;
use App\Config\Transaction as TransactionConfig;
use App\Repository\CryptocurrencyRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user/transactions', name: 'api.user.transactions.')]
class TransactionsController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        public LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    #[Route('/list', name: 'list', methods: ['GET'])]
    public function getList(): Response
    {
        $transactions = $this->entityManager
            ->getRepository(Transaction::class)
            ->findBy(['id' => $this->getUser()->getId()]);

        return $this->json([
            'transactions' => $this->serializer->serialize($transactions, 'json')
        ]);
    }

    /**
     * @param Request $request
     * @var string $cryptoBoughtSymbol
     * @var float $numberOfCryptoBought
     * @var float $value
     *
     * @return Response
     */
    #[Route('/new-bought-for-money', name: 'new-bought-for-money', methods: ['POST'])]
    public function newBoughtForMoney(Request $request, CryptocurrencyRepository $cryptocurrencyRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        $this->logger->debug("debug123", [$data]);

        $cryptoBoughtSymbol = str_replace('USDT', '', $data['cryptoBoughtSymbol']);
        $numberOfCryptoBought = $data['numberOfCryptoBought'];
        $value = $data['value'];


        $transaction = new Transaction();
        $transaction->setType(TransactionConfig::BOUGHT_FOR_MONEY);

        $cryptoBought = $cryptocurrencyRepository->findOneBy(['symbol' => $cryptoBoughtSymbol]);
        $transaction->setCryptoBought($cryptoBought);
        $transaction->setNumberOfCryptoBought($numberOfCryptoBought);
        $transaction->setValue($value);

        $date = new \DateTimeImmutable();
        $transaction->setCreatedAt($date);

        $transaction->setUser($this->getUser());

        $this->entityManager->persist($transaction);
        $this->entityManager->flush();

        return $this->json([
            'success' => true
        ]);
    }

    /**
     * @param Request $request
     * @var string $cryptoSoldSymbol
     * @var float $numberOfCryptoSold
     * @var float $value
     *
     * @return Response
     */
    #[Route('/new-sold-for-money', name: 'new-sold-for-money', methods: ['POST'])]
    public function newSoldForMoney(Request $request): Response
    {

        return $this->json([
            'success' => true
        ]);
    }

    /**
     * @param Request $request
     * @var string $cryptoBoughtSymbol
     * @var string $cryptoSoldSymbol
     * @var float $numberOfCryptoBought
     * @var float $numberOfCryptoSold
     * @var float $value
     *
     * @return Response
     */
    #[Route('/new-exchange-between-cryptos', name: 'new-exchange-between-cryptos', methods: ['POST'])]
    public function newExchangeBetweenCryptos(Request $request): Response
    {

        return $this->json([
            'success' => true
        ]);
    }
}