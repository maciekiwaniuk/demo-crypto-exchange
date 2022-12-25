<?php

namespace App\Dto\Api;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Constraint\UniqueValueInEntity;

class UserRegistrationDto extends BaseDto
{
    #[NotBlank()]
    #[Length([
        'min' => 5,
        'minMessage' => 'Username should be at least 5 characters long.',
        'max' => 100,
        'maxMessage' => 'Username can be up to 100 characters long.'
    ])]
    public $username;

    #[NotBlank()]
    #[Email()]
    #[Length([
        'min' => 5,
        'minMessage' => 'Email should be at least 5 characters long.',
        'max' => 100,
        'maxMessage' => 'Email can be up to 100 characters long.'
    ])]
    public $email;

    #[NotBlank()]
    #[Length([
        'min' => 5,
        'minMessage' => 'Password should be at least 5 characters long.',
        'max' => 100,
        'maxMessage' => 'Password can be up to 100 characters long.'
    ])]
    public $password;
}