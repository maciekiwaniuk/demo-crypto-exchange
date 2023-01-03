<?php

namespace App\Controller\Api\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/admin', name: 'api.admin.')]
class CryptocurrenciesController extends AbstractController
{
    #[Route('/get_cryptocurrencies', name: 'get_cryptocurrencies', methods: ['GET'])]
    public function getCryptocurrencies(): Response
    {
        return $this->json([
            'success' => true,
        ]);
    }
}