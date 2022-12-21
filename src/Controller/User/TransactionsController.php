<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/transactions', name: 'transactions.')]
class TransactionsController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
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
     * @var int $crypto_id_to - bought cryptocurrency
     * @var float $number_of_crypto_to - number of bought cryptocurrency
     * @var float $calculated_value - calculated value of transaction
     *
     * @return Response
     */
    #[Route('/bought-for-money-transaction', name: 'bought-for-money-transaction', methods: ['POST'])]
    public function boughtForMoneyTransaction(Request $request): Response
    {
        return $this->json([
            'success' => true
        ]);
    }
}