<?php

namespace App\Controller\Api\Admin;

use App\Dto\Api\Admin\NewCryptocurrencyDto;
use App\Entity\Cryptocurrency;
use App\Config\Cryptocurrency as CryptocurrencyConfig;
use App\Repository\CryptocurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/admin', name: 'api.admin.')]
class CryptocurrenciesController extends AbstractController
{
    public function __construct(
        private readonly CryptocurrencyRepository $cryptoRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route('/get-cryptos', name: 'get-cryptos', methods: ['GET'])]
    public function getList(): Response
    {
        $cryptocurrencies = $this->cryptoRepository
            ->findAll();

        return $this->json([
            'cryptos' => $this->serializer->serialize($cryptocurrencies, 'json')
        ]);
    }

    /**
     * @param NewCryptocurrencyDto $dto
     * @var string $symbol
     * @var string $status
     *
     * @return Response
     */
    #[Route('/new-crypto', name: 'new-crypto', methods: ['POST'])]
    public function new(NewCryptocurrencyDto $dto): Response
    {
        if ($dto->hasErrors()) {
            return $this->json([
                'success' => false,
                'errors' => $dto->getErrors()
            ]);
        }

        $crypto = new Cryptocurrency();
        $crypto->setSymbol($dto->symbol);
        $crypto->setStatus($dto->status);

        $this->cryptoRepository->save($crypto, true);

        return $this->json([
            'success' => true,
            'message' => 'Successfully added cryptocurrency.',
            'crypto' => $this->serializer->serialize($crypto, 'json')
        ]);
    }

    #[Route('/get-options-for-active-select', name: 'get-options-for-active-select', methods: ['GET'])]
    public function optionsForActiveSelect(): Response
    {
        $options = [
            CryptocurrencyConfig::ACTIVE_TEXT => CryptocurrencyConfig::ACTIVE,
            CryptocurrencyConfig::NOT_ACTIVE_TEXT => CryptocurrencyConfig::NOT_ACTIVE
        ];

        return $this->json(['options' => $options]);
    }

    #[Route('/delete-crypto/{id}', name: 'delete-crypto', methods: ['DELETE'])]
    public function delete(Cryptocurrency $crypto): Response
    {
        $this->cryptoRepository->remove($crypto, true);

        return $this->json([
            'success' => true,
            'message' => 'Successfully deleted crypto with symbol '.$crypto->getSymbol()
        ]);
    }

}