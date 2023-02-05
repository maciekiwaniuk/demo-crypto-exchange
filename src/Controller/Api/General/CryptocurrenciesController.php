<?php

namespace App\Controller\Api\General;

use App\Service\CryptocurrenciesDataService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api.')]
class CryptocurrenciesController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private CryptocurrenciesDataService $cryptoDataService;

    public function __construct(
        EntityManagerInterface $entityManager,
        CryptocurrenciesDataService $cryptoDataService,
        public LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->cryptoDataService = $cryptoDataService;
    }

    #[Route('/get_prices_of_active_cryptos', name: 'get_prices_of_active_cryptos', methods: ['GET'])]
    public function getPricesOfActiveCryptos(): Response
    {
        return $this->json([
           'cryptos' => $this->cryptoDataService->getActiveCryptoData()
        ]);
    }
}