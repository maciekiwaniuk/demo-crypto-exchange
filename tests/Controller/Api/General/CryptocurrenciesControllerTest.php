<?php

namespace App\Tests\Controller\Api\General;

use App\Tests\TestCase\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CryptocurrenciesControllerTest extends WebTestCase
{
    public const URL = '/api/crypto';

    public function testGettingPricesOfActiveCryptos(): void
    {
        $client = self::createGuestApiClient();

        $client->request('GET', self::URL . '/get-prices-of-active-cryptos');

        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('cryptos', $responseData);
    }
}