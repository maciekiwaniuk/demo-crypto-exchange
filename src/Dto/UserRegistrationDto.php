<?php

namespace App\Dto;

use App\Entity\User;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegistrationDto
{
    #[NotBlank]
    #[Email]
    public $email;

    #[NotBlank]
    #[Length([
        "min" => 3,
        "minMessage" => "Min 3 chars",
        "max" => 30,
        "maxMessage" => "Max 30 chars"
    ])]
    public $username;

    #[NotBlank]
    #[Length([
        "min" => 8,
        "minMessage" => "Min 8 chars",
        "max" => 50,
        "maxMessage" => "Max 50 chars"
    ])]
    public $password;


}