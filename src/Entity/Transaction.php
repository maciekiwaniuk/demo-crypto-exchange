<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'type')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\ManyToOne]
    private ?Cryptocurrency $crypto_id_sold = null;

    #[ORM\ManyToOne]
    private ?Cryptocurrency $crypto_id_bought = null;

    #[ORM\Column(nullable: true)]
    private ?float $number_of_crypto_sold = null;

    #[ORM\Column(nullable: true)]
    private ?float $number_of_crypto_bought = null;

    #[ORM\Column]
    private ?float $value = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCryptoIdSold(): ?Cryptocurrency
    {
        return $this->crypto_id_sold;
    }

    public function setCryptoIdSold(?Cryptocurrency $crypto_id_sold): self
    {
        $this->crypto_id_sold = $crypto_id_sold;

        return $this;
    }

    public function getCryptoIdBought(): ?Cryptocurrency
    {
        return $this->crypto_id_bought;
    }

    public function setCryptoIdBought(?Cryptocurrency $crypto_id_bought): self
    {
        $this->crypto_id_bought = $crypto_id_bought;

        return $this;
    }

    public function getNumberOfCryptoSold(): ?float
    {
        return $this->number_of_crypto_sold;
    }

    public function setNumberOfCryptoSold(?float $number_of_crypto_sold): self
    {
        $this->number_of_crypto_sold = $number_of_crypto_sold;

        return $this;
    }

    public function getNumberOfCryptoBought(): ?float
    {
        return $this->number_of_crypto_bought;
    }

    public function setNumberOfCryptoBought(?float $number_of_crypto_bought): self
    {
        $this->number_of_crypto_bought = $number_of_crypto_bought;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
