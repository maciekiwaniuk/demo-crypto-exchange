<?php

namespace App\Config;

enum Transaction
{
    public const BOUGHT_FOR_MONEY = 'bought_for_money';
    public const SOLD_FOR_MONEY = 'sold_for_money';

    public const EXCHANGE_BETWEEN_CRYPTOS = 'exchange_between_cryptos';
}