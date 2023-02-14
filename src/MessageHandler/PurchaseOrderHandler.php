<?php

namespace App\MessageHandler;

use App\Message\PurchaseOrder;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class PurchaseOrderHandler
{
    public function __invoke(PurchaseOrder $order): void
    {

    }
}