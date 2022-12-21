<?php

namespace App\Config;

enum Log
{
    const LOGIN = 'login';
    const REGISTER = 'register';

    const BOUGHT_FOR_MONEY_TRANSACTION = 'bought_for_money_transaction';
    const SOLD_FOR_MONEY_TRANSACTION = 'sold_for_money_transaction';
    const EXCHANGE_BETWEEN_CRYPTOS = 'exchange_between_cryptos_transaction';
}