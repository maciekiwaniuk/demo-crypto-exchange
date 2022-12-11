<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserLoginDto
{
    #[Email]
    public $email;

    #[NotBlank]
    public $password;
}