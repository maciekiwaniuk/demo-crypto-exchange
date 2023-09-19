<?php

namespace App\Controller\Api\General;

use App\Service\CryptocurrenciesDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/crypto', name: 'api.crypto.')]
class CryptocurrenciesController extends AbstractController
{
    public function __construct(
        protected readonly CryptocurrenciesDataService $cryptoDataService
    ) {
    }

    #[Route('/get-prices-of-active-cryptos', name: 'get-prices-of-active-cryptos', methods: ['GET'])]
    public function getPricesOfActiveCryptos(): Response
    {
        return $this->json([
           'cryptos' => $this->cryptoDataService->getActiveCryptoData()
        ]);
    }
}