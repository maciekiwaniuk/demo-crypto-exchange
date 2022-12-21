<?php

namespace App\Config;

enum Transaction
{
    const BOUGHT_FOR_MONEY = 'bought_for_money';
    const SOLD_FOR_MONEY = 'sold_for_money';

    const EXCHANGE_BETWEEN_CRYPTOS = 'exchange_between_cryptos';
}