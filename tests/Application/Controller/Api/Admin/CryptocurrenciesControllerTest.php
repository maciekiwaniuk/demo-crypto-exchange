<?php

namespace App\Tests\Application\Controller\Api\Admin;

use App\Config\Cryptocurrency as CryptocurrencyConfig;
use App\Entity\Cryptocurrency;
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
        $client = self::createAuthenticatedAdminApiClient();

        $data = [
            'symbol' => 'DOGE',
            'status' => CryptocurrencyConfig::ACTIVE
        ];
        $createUrl = self::URL . '/new-crypto';
        $client->request('POST', $createUrl, [], [], [], json_encode($data));

        $createResponse = $client->getResponse();
        $createResponseData = json_decode($createResponse->getContent(), true);
        $cryptoData = json_decode($createResponseData['crypto']);

        $deleteUrl = self::URL . '/delete-crypto/' . $cryptoData->id;
        $client->reload();
        $client->request('DELETE', $deleteUrl);
        $deleteResponse = $client->getResponse();
        $deleteResponseData = json_decode($deleteResponse->getContent(), true);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK, $deleteResponse->getStatusCode());
        $this->assertSame($deleteResponseData['success'], true);
        $this->assertArrayHasKey('message', $deleteResponseData);
    }
}