<?php

namespace App\Factory;

use App\Config\Cryptocurrency as CryptocurrencyConfig;
use App\Entity\Cryptocurrency;
use App\Repository\CryptocurrencyRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Cryptocurrency>
 *
 * @method        Cryptocurrency|Proxy create(array|callable $attributes = [])
 * @method static Cryptocurrency|Proxy createOne(array $attributes = [])
 * @method static Cryptocurrency|Proxy find(object|array|mixed $criteria)
 * @method static Cryptocurrency|Proxy findOrCreate(array $attributes)
 * @method static Cryptocurrency|Proxy first(string $sortedField = 'id')
 * @method static Cryptocurrency|Proxy last(string $sortedField = 'id')
 * @method static Cryptocurrency|Proxy random(array $attributes = [])
 * @method static Cryptocurrency|Proxy randomOrCreate(array $attributes = [])
 * @method static CryptocurrencyRepository|RepositoryProxy repository()
 * @method static Cryptocurrency[]|Proxy[] all()
 * @method static Cryptocurrency[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Cryptocurrency[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Cryptocurrency[]|Proxy[] findBy(array $attributes)
 * @method static Cryptocurrency[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Cryptocurrency[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class CryptocurrencyFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return [
            'status' => CryptocurrencyConfig::ACTIVE,
            'symbol' => array_rand([
                'BTC', 'ETH', 'DOGE'
            ])
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Cryptocurrency $cryptocurrency): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Cryptocurrency::class;
    }
}
