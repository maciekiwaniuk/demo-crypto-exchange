<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserService
{
    public function getUserWithSetLastLoginAttributes(User $user, Request $request): User
    {

    }
}