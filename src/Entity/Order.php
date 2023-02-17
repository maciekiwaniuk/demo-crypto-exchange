<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Config\Order as OrderConfig;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: "`order`")]
class Order
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

    #[ORM\Column]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: Cryptocurrency::class)]
    private ?Cryptocurrency $cryptoToSell = null;

    #[ORM\ManyToOne(targetEntity: Cryptocurrency::class)]
    private ?Cryptocurrency $cryptoToBuy = null;

    #[ORM\Column(nullable: true)]
    private ?float $amountOfCryptoToSell = null;

    #[ORM\Column(nullable: true)]
    private ?float $amountOfCryptoToBuy = null;

    #[ORM\Column]
    private ?float $value = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $doneAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCryptoToSell(): ?Cryptocurrency
    {
        return $this->cryptoToSell;
    }

    public function setCryptoToSell(?Cryptocurrency $cryptoToSell): self
    {
        $this->cryptoToSell = $cryptoToSell;

        return $this;
    }

    public function getCryptoToBuy(): ?Cryptocurrency
    {
        return $this->cryptoToBuy;
    }

    public function setCryptoToBuy(?Cryptocurrency $cryptoToBuy): self
    {
        $this->cryptoToBuy = $cryptoToBuy;

        return $this;
    }

    public function getAmountOfCryptoToSell(): ?float
    {
        return $this->amountOfCryptoToSell;
    }

    public function setAmountOfCryptoToSell(?float $amountOfCryptoToSell): self
    {
        $this->amountOfCryptoToSell = $amountOfCryptoToSell;

        return $this;
    }

    public function getAmountOfCryptoToBuy(): ?float
    {
        return $this->amountOfCryptoToBuy;
    }

    public function setAmountOfCryptoToBuy(?float $amountOfCryptoToBuy): self
    {
        $this->amountOfCryptoToBuy = $amountOfCryptoToBuy;

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

    public function getDoneAt(): ?\DateTimeImmutable
    {
        return $this->doneAt;
    }

    public function setDoneAt(\DateTimeImmutable $doneAt): self
    {
        $this->doneAt = $doneAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}