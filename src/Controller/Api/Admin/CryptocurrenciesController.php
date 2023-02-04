<?php

namespace App\Controller\Api\Admin;

use App\Dto\Api\Admin\NewCryptocurrencyDto;
use App\Entity\Cryptocurrency;
use App\Config\Cryptocurrency as CryptocurrencyConfig;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/admin', name: 'api.admin.')]
class CryptocurrenciesController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    #[Route('/get_cryptos', name: 'get_cryptos', methods: ['GET'])]
    public function getList(): Response
    {
        $cryptocurrencies = $this->entityManager
            ->getRepository(Cryptocurrency::class)
            ->findAll();

        return $this->json([
            'success' => true,
            'cryptos' => $this->serializer->serialize($cryptocurrencies, 'json')
        ]);
    }

    #[Route('/new_crypto', name: 'new_crypto', methods: ['POST'])]
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
        $crypto->setActive($dto->active);

        $this->entityManager->persist($crypto);
        $this->entityManager->flush();

        return $this->json([
            'success' => true,
            'message' => 'Successfully added cryptocurrency.',
            'crypto' => $this->serializer->serialize($crypto, 'json')
        ]);
    }

    #[Route('/get_options_for_active_select', name: 'get_options_for_active_select', methods: ['GET'])]
    public function optionsForActiveSelect(): Response
    {
        $options = [
            CryptocurrencyConfig::ACTIVE_TEXT => CryptocurrencyConfig::ACTIVE,
            CryptocurrencyConfig::NOT_ACTIVE_TEXT => CryptocurrencyConfig::NOT_ACTIVE
        ];

        return $this->json(['options' => $options]);
    }

    #[Route('/delete_crypto/{id}', name: 'delete_crypto', methods: ['DELETE'])]
    public function delete(Cryptocurrency $crypto) : Response
    {
        $this->entityManager->remove($crypto);
        $this->entityManager->flush();

        return $this->json([
            'success' => true,
            'message' => 'Successfully deleted crypto with symbol '.$crypto->getSymbol()
        ]);
    }

}