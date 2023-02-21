<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\HasLifecycleCallbacks]
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

    #[ORM\Column]
    private ?int $attempts = 0;

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

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $doneAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

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

    public function getAttempts(): ?int
    {
        return $this->attempts;
    }

    public function increaseAttempts(): self
    {
        $this->attempts += 1;

        return $this;
    }

    public function setAttempts(int $attempts): self
    {
        $this->attempts = $attempts;

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


}