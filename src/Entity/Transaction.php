<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?User $user = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: Cryptocurrency::class)]
    private ?Cryptocurrency $crypto_sold = null;

    #[ORM\ManyToOne(targetEntity: Cryptocurrency::class)]
    private ?Cryptocurrency $crypto_bought = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getCryptoSold(): ?Cryptocurrency
    {
        return $this->crypto_sold;
    }

    public function setCryptoSold(?Cryptocurrency $crypto_sold): self
    {
        $this->crypto_sold = $crypto_sold;

        return $this;
    }

    public function getCryptoBought(): ?Cryptocurrency
    {
        return $this->crypto_bought;
    }

    public function setCryptoBought(?Cryptocurrency $crypto_bought): self
    {
        $this->crypto_bought = $crypto_bought;

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
