<?php

namespace App\Tests\Unit\Entity;

use App\Config\Log as LogConfig;
use App\Entity\Log;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class LogTest extends KernelTestCase
{
    use ResetDatabase;

    public function testCreatingInstance(): void
    {
        $userFactory = self::getContainer()->get(UserFactory::class);
        $user = $userFactory->createOne()->object();

        $description = 'Example description.';
        $ip = '127.0.0.1';

        $log = new Log();
        $log->setType(LogConfig::LOGIN)
            ->setDescription($description)
            ->setIp($ip)
            ->setUser($user);

        $this->assertSame(LogConfig::LOGIN, $log->getType());
        $this->assertSame($description, $log->getDescription());
        $this->assertSame($ip, $log->getIp());
        $this->assertSame($user, $log->getUser());
        $this->assertNotEmpty($log->getCreatedAt());
    }
}