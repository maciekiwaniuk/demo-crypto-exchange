<?php

namespace App\Tests\Controller;

use App\Tests\TestCase\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class EntryControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = $this->createGuestApiClient();
        $client->request('GET', '/');

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}