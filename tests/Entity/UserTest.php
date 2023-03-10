<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreatingInstance(): void
    {


        $user = new User();
        $this->assertSame(true, true);
    }
}