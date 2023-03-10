<?php

namespace App\Tests\Entity;

use App\Config\User as UserConfig;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserTest extends KernelTestCase
{
    public function testCreatingInstance(): void
    {
        $passwordHasher = self::getContainer()->get(UserPasswordHasherInterface::class);

        $lastLoginIp = '127.0.0.1';
        $lastLoginTime = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        $lastUserAgent = 'Chrome';

        $user = new User();

        $hashedPassword = $passwordHasher->hashPassword(
            $user, UserConfig::DEFAULT_ADMIN_PASSWORD
        );

        $user->setEmail(UserConfig::DEFAULT_ADMIN_EMAIL)
            ->setPassword($hashedPassword)
            ->setUsername(UserConfig::DEFAULT_ADMIN_USERNAME)
            ->setRoles([UserConfig::ROLE_ADMIN])
            ->setLastLoginIp($lastLoginIp)
            ->setLastLoginTime($lastLoginTime)
            ->setLastUserAgent($lastUserAgent);

        $this->assertSame(UserConfig::DEFAULT_ADMIN_EMAIL, $user->getEmail());
        $this->assertSame($hashedPassword, $user->getPassword());
        $this->assertSame(UserConfig::DEFAULT_ADMIN_USERNAME, $user->getUsername());
        $this->assertSame([UserConfig::ROLE_ADMIN, UserConfig::ROLE_USER], $user->getRoles());
        $this->assertSame($lastLoginIp, $user->getLastLoginIp());
        $this->assertSame($lastLoginTime, $user->getLastLoginTime());
        $this->assertSame($lastUserAgent, $user->getLastUserAgent());
    }
}