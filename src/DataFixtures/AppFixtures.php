<?php

namespace App\DataFixtures;

use App\Config\User as UserConfig;
use App\Entity\User;
use App\Factory\CryptocurrencyFactory;
use App\Factory\OrderFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        CryptocurrencyFactory::createOne(['symbol' => 'BTC']);
        CryptocurrencyFactory::createOne(['symbol' => 'ETH']);
        CryptocurrencyFactory::createOne(['symbol' => 'DOGE']);

        //UserFactory::createMany(10);
        $admin = UserFactory::createOne([
            'email' => UserConfig::DEFAULT_ADMIN_EMAIL,
            'username' => UserConfig::DEFAULT_ADMIN_USERNAME,
            'password' => $this->passwordHasher->hashPassword(
                new User(),
                UserConfig::DEFAULT_ADMIN_PASSWORD
            ),
            'roles' => [UserConfig::ROLE_ADMIN]
        ]);

        OrderFactory::createMany(25, [
            'user' => $admin
        ]);
        
        $manager->flush();
    }
}
