<?php

namespace App\Entity;

use App\Repository\CryptocurrencyRepository;
use App\Config\Cryptocurrency as CryptocurrencyConfig;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CryptocurrencyRepository::class)]
class Cryptocurrency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $symbol = null;

    #[ORM\Column]
    private string $active = CryptocurrencyConfig::ACTIVE;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function isActive(): string
    {
        return $this->active;
    }

    public function setActive(string $active): self
    {
        $this->active = $active;

        return $this;
    }
}
