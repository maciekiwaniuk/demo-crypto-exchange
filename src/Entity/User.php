<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Config\BanStatus;
use App\Config\User as UserEnum;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Mapping\ClassMetadata;

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

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private ?float $balance = UserEnum::DEFAULT_BALANCE;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastLoginIp = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastLoginTime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastUserAgent = null;

    #[ORM\Column]
    private ?string $banStatus = BanStatus::NOT_BANNED;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('email', new Email());
        $metadata->addPropertyConstraint('username',
            new Length([
                'min' => 6,
                'minMessage' => 'Your password should be at least {{ limit }} characters',
                'max' => 40
            ])
        );
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

    /**
     * @see PasswordAuthenticatedUserInterface
     */
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

    public function getBanStatus(): ?int
    {
        return $this->banStatus;
    }

    public function setBanStatus(int $banStatus): self
    {
        $this->banStatus = $banStatus;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
