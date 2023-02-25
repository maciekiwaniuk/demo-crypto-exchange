<?php

namespace App\Factory;

use App\Config\Order as OrderConfig;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Psr\Log\LoggerInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Order>
 *
 * @method        Order|Proxy create(array|callable $attributes = [])
 * @method static Order|Proxy createOne(array $attributes = [])
 * @method static Order|Proxy find(object|array|mixed $criteria)
 * @method static Order|Proxy findOrCreate(array $attributes)
 * @method static Order|Proxy first(string $sortedField = 'id')
 * @method static Order|Proxy last(string $sortedField = 'id')
 * @method static Order|Proxy random(array $attributes = [])
 * @method static Order|Proxy randomOrCreate(array $attributes = [])
 * @method static OrderRepository|RepositoryProxy repository()
 * @method static Order[]|Proxy[] all()
 * @method static Order[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Order[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Order[]|Proxy[] findBy(array $attributes)
 * @method static Order[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Order[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class OrderFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct(public LoggerInterface $logger)
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        $types = [
            OrderConfig::BUY_FOR_MONEY, OrderConfig::SELL_FOR_MONEY
        ];
        $drawnType = $types[array_rand($types)];

        $baseData = [
            'user' => UserFactory::new(),
            'status' => OrderConfig::COMPLETED,
            'attempts' => 1,
            'value' => self::faker()->randomFloat(2, 100, 50_000),
        ];

        $symbols = ['BTC', 'ETH', 'DOGE'];
        if ($drawnType == OrderConfig::BUY_FOR_MONEY) {
            $drawnData = [
                'type' => OrderConfig::BUY_FOR_MONEY,
                'cryptoToBuy' => CryptocurrencyFactory::randomOrCreate([
                    'symbol' => $symbols[array_rand($symbols)]
                ]),
                'amountOfCryptoToBuy' => self::faker()->randomFloat(2, 0.05, 10)
            ];

        } else if ($drawnType == OrderConfig::SELL_FOR_MONEY) {
            $drawnData = [
                'type' => OrderConfig::SELL_FOR_MONEY,
                'cryptoToSell' => CryptocurrencyFactory::randomOrCreate([
                    'symbol' => $symbols[array_rand($symbols)]
                ]),
                'amountOfCryptoToSell' => self::faker()->randomFloat(2, 0.05, 10)
            ];
        } else {

            $drawnData = [];
        }

        return array_merge($baseData, $drawnData);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Order $order): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Order::class;
    }
}
