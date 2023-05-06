<?php

namespace App\Tests\Application\Security;

use App\Config\User as UserConfig;
use App\Entity\User;
use App\Factory\UserFactory;
use App\Tests\Application\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthenticationTest extends WebTestCase
{
    const URL = '/api/login-check';

    public function testUserCantLoginWithInvalidCredentials()
    {
        $client = $this->createGuestApiClient();
        $data = [
            'email' => 'invalid@email.pl',
            'password' => 'invalidPassword',
        ];
        $client->request('POST', self::URL, [], [], [], json_encode($data));

        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertArrayHasKey('success', $responseData);
        $this->assertArrayHasKey('message', $responseData);
    }

    public function testUserCanLoginWithValidCredentials()
    {
        $container = static::getContainer();

        $passwordHasher = $container->get(UserPasswordHasherInterface::class);

        $email = UserConfig::DEFAULT_ADMIN_EMAIL;
        $password = UserConfig::DEFAULT_ADMIN_PASSWORD;
        UserFactory::createOne([
            'email' => $email,
            'password' => $passwordHasher->hashPassword(
                new User(), $password
            )
        ]);

        self::ensureKernelShutdown();
        $client = $this->createGuestApiClient();
        $data = [
            'email' => $email,
            'password' => $password,
        ];
        $client->request('POST', self::URL, [], [], [], json_encode($data));

        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('success', $responseData);
        $this->assertArrayHasKey('token', $responseData);
        $this->assertArrayHasKey('roles', $responseData);
    }

}