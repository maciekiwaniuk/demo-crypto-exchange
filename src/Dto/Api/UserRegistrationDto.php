<?php

namespace App\Dto\Api;

use App\Entity\User;
use App\Validator\Constraints\UniqueFieldInEntity;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegistrationDto extends BaseDto
{
    #[NotBlank()]
    #[Length([
        'min' => 5,
        'minMessage' => 'Username should be at least 5 characters long.',
        'max' => 100,
        'maxMessage' => 'Username can be up to 100 characters long.'
    ])]
    #[UniqueFieldInEntity(
        field: 'username',
        entityClassName: User::class
    )]
    public string $username;

    #[NotBlank()]
    #[Email()]
    #[Length([
        'min' => 5,
        'minMessage' => 'Email should be at least 5 characters long.',
        'max' => 100,
        'maxMessage' => 'Email can be up to 100 characters long.'
    ])]
    #[UniqueFieldInEntity(
        field: 'email',
        entityClassName: User::class
    )]
    public string $email;

    #[NotBlank()]
    #[Length([
        'min' => 5,
        'minMessage' => 'Password should be at least 5 characters long.',
        'max' => 100,
        'maxMessage' => 'Password can be up to 100 characters long.'
    ])]
    public string $password;
}