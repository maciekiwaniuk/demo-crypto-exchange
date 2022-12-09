<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class UserRegistrationDto
{
    #[Email]
    public $email;

    #[Length([
        "min" => 3,
        "minMessage" => "Min 3 chars",
        "max" => 30,
        "maxMessage" => "Max 30 chars"
    ])]
    public $username;

    #[Length([
        "min" => 8,
        "minMessage" => "Min 8 chars",
        "max" => 50,
        "maxMessage" => "Max 50 chars"
    ])]
    public $password;

}