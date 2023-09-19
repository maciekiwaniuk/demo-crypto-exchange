<?php

namespace App\Config;

class Order
{
    // type
    public const EXCHANGE_BETWEEN_CRYPTOS = 'exchange_between_cryptos';
    public const BUY_FOR_MONEY = 'buy_for_money';
    public const SELL_FOR_MONEY = 'sell_for_money';

    // status
    public const PENDING = 'pending';
    public const CANCELED = 'canceled';
    public const COMPLETED = 'completed';
    public const TOO_MANY_ATTEMPTS = 'too_many_attempts';

    // attempts
    public const MAX_ATTEMPTS = 10;
}