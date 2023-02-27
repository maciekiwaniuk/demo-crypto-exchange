<?php

namespace App\Tests\TestCase;

use App\Entity\User;
use App\Factory\UserFactory;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
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
        $user = static::getContainer()->get(UserFactory::createOne());

        if (!$user instanceof User) {
            throw new \InvalidArgumentException('User not found.');
        }

        $token = static::getContainer()->get(JWTTokenManagerInterface::class)->create($user);
        static::ensureKernelShutdown();

        return static::createClient([], [
            'CONTENT_TYPE' => 'application/json',
            'AUTHORIZATION' => 'Bearer ' . $token,
        ]);
    }
}
