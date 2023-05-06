<?php

namespace App\Tests\Application;

use App\Config\User as UserConfig;
use App\Entity\User;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class WebTestCase extends BaseWebTestCase
{
    use ResetDatabase, Factories;

    protected function createGuestApiClient(): KernelBrowser
    {
        return static::createClient([], [
            'CONTENT_TYPE' => 'application/json',
        ]);
    }

    protected function createAuthenticatedUserApiClient(): KernelBrowser
    {
        $container = static::getContainer();

        $passwordHasher = $container->get(UserPasswordHasherInterface::class);

        $container->get(UserFactory::class)
            ->createOne([
                'email' => UserConfig::DEFAULT_ADMIN_EMAIL,
                'password' => $passwordHasher->hashPassword(
                    new User(), UserConfig::DEFAULT_ADMIN_PASSWORD
                )
            ]);

        static::ensureKernelShutdown();
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login-check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => UserConfig::DEFAULT_ADMIN_EMAIL,
                'password' => UserConfig::DEFAULT_ADMIN_PASSWORD,
            ])
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    protected function createAuthenticatedAdminApiClient(): KernelBrowser
    {
        $container = static::getContainer();

        $passwordHasher = $container->get(UserPasswordHasherInterface::class);

        $container->get(UserFactory::class)
            ->createOne([
                'email' => UserConfig::DEFAULT_ADMIN_EMAIL,
                'password' => $passwordHasher->hashPassword(
                    new User(), UserConfig::DEFAULT_ADMIN_PASSWORD
                ),
                'roles' => [UserConfig::ROLE_ADMIN]
            ]);

        static::ensureKernelShutdown();
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login-check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => UserConfig::DEFAULT_ADMIN_EMAIL,
                'password' => UserConfig::DEFAULT_ADMIN_PASSWORD,
            ])
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }


}
