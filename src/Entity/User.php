<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Config\User as UserConfig;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 30, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private float $balance = UserConfig::DEFAULT_BALANCE;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $lastLoginIp = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $lastLoginTime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastUserAgent = null;

    #[ORM\Column]
    private string $banStatus = UserConfig::NOT_BANNED;

    #[ORM\Column(length: 20, nullable: true)]
    private string $isVerified = UserConfig::EMAIL_NOT_VERIFIED;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Log::class, orphanRemoval: true)]
    private Collection $logs;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Transaction::class, orphanRemoval: true)]
    private Collection $transactions;

    public function __construct()
    {
        $this->logs = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    public function fillDataAfterSuccessfulAuthentication(string $ip, string $userAgent, \DateTime $time): void
    {
        $this->setLastLoginIp($ip);
        $this->setLastUserAgent($userAgent);
        $this->setLastLoginTime($time->format('Y-m-d h:i:s'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function isAdmin(): bool
    {
        if (in_array('ROLE_ADMIN', $this->roles)) {
            return true;
        }

        return false;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->password = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getLastLoginIp(): ?string
    {
        return $this->lastLoginIp;
    }

    public function setLastLoginIp(?string $lastLoginIp): self
    {
        $this->lastLoginIp = $lastLoginIp;

        return $this;
    }

    public function getLastLoginTime(): ?string
    {
        return $this->lastLoginTime;
    }

    public function setLastLoginTime(string $lastLoginTime): self
    {
        $this->lastLoginTime = $lastLoginTime;

        return $this;
    }

    public function getLastUserAgent(): ?string
    {
        return $this->lastUserAgent;
    }

    public function setLastUserAgent(string $lastUserAgent): self
    {
        $this->lastUserAgent = $lastUserAgent;

        return $this;
    }

    public function getBanStatus(): bool
    {
        return $this->banStatus === UserConfig::BANNED;
    }

    public function setBanStatus(bool $banStatus): self
    {
        $this->banStatus = $banStatus ? UserConfig::BANNED : UserConfig::NOT_BANNED;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified === UserConfig::EMAIL_VERIFIED;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified ? UserConfig::EMAIL_VERIFIED : UserConfig::EMAIL_NOT_VERIFIED;

        return $this;
    }

    /**
     * @return Collection<int, Log>
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs->add($log);
            $log->setUserId($this);
        }

        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->removeElement($log)) {
            // set the owning side to null (unless already changed)
            if ($log->getUserId() === $this) {
                $log->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setUserId($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getUserId() === $this) {
                $transaction->setUserId(null);
            }
        }

        return $this;
    }
}
