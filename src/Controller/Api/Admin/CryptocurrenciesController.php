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

    #[Route('/get_cryptocurrencies', name: 'get_cryptocurrencies', methods: ['GET'])]
    public function getList(): Response
    {
        $cryptocurrencies = $this->entityManager
            ->getRepository(Cryptocurrency::class)
            ->findAll();

        return $this->json([
            'success' => true,
            'cryptocurrencies' => $this->serializer->serialize($cryptocurrencies, 'json')
        ]);
    }

    #[Route('/new_cryptocurrency', name: 'new_cryptocurrency', methods: ['POST'])]
    public function new(NewCryptocurrencyDto $dto): Response
    {
        if ($dto->hasErrors()) {
            return $this->json([
                'success' => false,
                'errors' => $dto->getErrors()
            ]);
        }

        $cryptocurrency = new Cryptocurrency();
        $cryptocurrency->setSymbol($dto->symbol);
        $cryptocurrency->setActive($dto->active);

        $this->entityManager->persist($cryptocurrency);
        $this->entityManager->flush();

        return $this->json([
            'success' => true,
            'message' => 'Successfully added cryptocurrency.',
            'cryptocurrency' => $this->serializer->serialize($cryptocurrency, 'json')
        ]);
    }

    #[Route('/options_for_active_select', name: 'options_for_active_select', methods: ['GET'])]
    public function optionsForActiveSelect(): Response
    {
        $options = [
            CryptocurrencyConfig::ACTIVE_TEXT => CryptocurrencyConfig::ACTIVE,
            CryptocurrencyConfig::NOT_ACTIVE_TEXT => CryptocurrencyConfig::NOT_ACTIVE
        ];

        return $this->json(['options' => $options]);
    }

}