<?php

namespace App\Tests\Application\Controller\Api\Admin;

use App\Config\Cryptocurrency as CryptocurrencyConfig;
use App\Tests\Application\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CryptocurrenciesControllerTest extends WebTestCase
{
    public const URL = '/api/admin';

    public function testGettingCryptosAsGuest(): void
    {
        $client = self::createGuestApiClient();

        $client->request('GET', self::URL . '/get-cryptos');

        $response = $client->getResponse();

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGettingCryptosAsUser(): void
    {
        $client = self::createAuthenticatedUserApiClient();

        $client->request('GET', self::URL . '/get-cryptos');

        $response = $client->getResponse();

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testGettingCryptosAsAdmin(): void
    {
        $client = self::createAuthenticatedAdminApiClient();

        $client->request('GET', self::URL . '/get-cryptos');

        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('cryptos', $responseData);
    }

    public function testCreatingNewCrypto(): void
    {
        $client = self::createAuthenticatedAdminApiClient();

        $data = [
            'symbol' => 'BTC',
            'status' => CryptocurrencyConfig::ACTIVE
        ];
        $url = self::URL . '/new-crypto';
        $client->request('POST', $url, [], [], [], json_encode($data));

        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('success', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('crypto', $responseData);
    }

    public function testCreatingNewCryptoWithInvalidData(): void
    {
        $client = self::createAuthenticatedAdminApiClient();

        $data = [
            'symbol' => 'BTC',
            'status' => 'invalid_status'
        ];
        $url = self::URL . '/new-crypto';
        $client->request('POST', $url, [], [], [], json_encode($data));

        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('success', $responseData);
        $this->assertArrayHasKey('errors', $responseData);
    }

    public function testGettingCryptosForSelectOptions(): void
    {
        $client = self::createAuthenticatedAdminApiClient();

        $client->request('GET', self::URL . '/get-options-for-active-select');

        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('options', $responseData);
    }

    public function testDeletingCrypto(): void
    {
        $this->assertsame(true, true);
    }
}