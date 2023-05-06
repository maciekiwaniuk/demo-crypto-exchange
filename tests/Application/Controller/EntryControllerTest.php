<?php

namespace App\Tests\Application\Controller;

use App\Tests\Application\WebTestCase;
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