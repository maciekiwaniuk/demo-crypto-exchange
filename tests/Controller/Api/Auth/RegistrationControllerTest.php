<?php

namespace App\Tests\Controller\Api\Auth;

use App\Config\User as UserConfig;
use App\Tests\TestCase\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegistrationControllerTest extends WebTestCase
{
    const URL = '/api/register';

    public function testRegistrationWithValidData()
    {
        $client = $this->createGuestApiClient();
        $data = [
            'username' => UserConfig::DEFAULT_ADMIN_USERNAME,
            'email' => UserConfig::DEFAULT_ADMIN_EMAIL,
            'password' => UserConfig::DEFAULT_ADMIN_PASSWORD,
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