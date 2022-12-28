<?php

namespace App\Tests\Controller\Api\Auth;

use App\Tests\TestCase\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegistrationControllerTest extends WebTestCase
{
    const URL = '/api/register';

    public function testRegistrationWithValidData()
    {
        $client = $this->createGuestApiClient();
        $data = [
            'username' => 'test1234',
            'email' => 'test1234@wp.pl',
            'password' => 'test1234',
            'password_confirm' => 'test1234'
        ];
        $client->request('POST', self::URL, [], [], [], json_encode($data));

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}