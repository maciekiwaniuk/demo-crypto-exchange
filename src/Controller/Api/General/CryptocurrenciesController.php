<?php

namespace App\Controller\Api\General;

use App\Service\CryptocurrenciesDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/crypto', name: 'api.crypto.')]
class CryptocurrenciesController extends AbstractController
{
    private CryptocurrenciesDataService $cryptoDataService;

    public function __construct(
        CryptocurrenciesDataService $cryptoDataService,
    ) {
        $this->cryptoDataService = $cryptoDataService;
    }

    #[Route('/get-prices-of-active-cryptos', name: 'get_prices_of_active_cryptos', methods: ['GET'])]
    public function getPricesOfActiveCryptos(): Response
    {
        return $this->json([
           'cryptos' => $this->cryptoDataService->getActiveCryptoData()
        ]);
    }
}