<?php

namespace App\Tests\Security;

use App\Tests\TestCase\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationTest extends WebTestCase
{
    const URL = '/api/login_check';

    public function testUserCanLoginWithValidCredentials()
    {
        $client = $this->createGuestApiClient();
        $data = [
            'email' => 'test1234@wp.pl',
            'password' => 'test1234',
        ];
        $client->request('POST', self::URL, [], [], [], json_encode($data));

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testUserCantLoginWithInvalidCredentials()
    {
        $client = $this->createGuestApiClient();
        $data = [
            'email' => 'foo@test.pl',
            'password' => 'foo123',
        ];
        $client->request('POST', self::URL, [], [], [], json_encode($data));

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertArrayHasKey('success', $data);
        $this->assertSame($data['success'], false);
        $this->assertArrayHasKey('message', $data);
    }
}