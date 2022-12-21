<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/transactions', name: 'transactions.')]
class TransactionsController extends AbstractController
{
    private Security $security;
    private HttpClientInterface $httpClient;

    public function __construct(Security $security, HttpClientInterface $httpClient)
    {
        $this->security = $security;
        $this->httpClient = $httpClient;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('user/transactions/index.html.twig');
    }

    /**
     * Handles transaction which user buys cryptocurrency for money.
     *
     * @param Request $request
     * @var int $crypto_id_bought - bought cryptocurrency
     * @var float $number_of_crypto_bought - number of bought cryptocurrency
     * @var float $calculated_value - calculated value of transaction
     *
     * @return Response
     */
    #[Route('/bought-for-money', name: 'bought-for-money', methods: ['POST'])]
    public function boughtForMoney(Request $request): Response
    {
        return $this->json([
            'success' => true
        ]);
    }
}