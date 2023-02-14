<?php

namespace App\Controller\Api\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user/market', name: 'api.user.market.')]
class MarketController extends AbstractController
{
    public function new(Request $request, MessageBusInterface $bus): Response
    {

    }
}