<?php

namespace App\Dto\Api\Admin;

use App\Config\Cryptocurrency as CryptocurrencyConfig;
use App\Constraint\UniqueFieldInEntity;
use App\Dto\Api\BaseDto;
use App\Entity\Cryptocurrency;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewCryptocurrencyDto extends BaseDto
{
    #[NotBlank()]
    #[Length([
        'min' => 2,
        'minMessage' => 'Symbol should be at least 2 characters long.',
        'max' => 20,
        'maxMessage' => 'Symbol can be up to 20 characters long.'
    ])]
    #[UniqueFieldInEntity(
        field: 'symbol',
        entityClassName: Cryptocurrency::class
    )]
    public string $symbol;

    #[NotBlank()]
    #[Length([
        'min' => 1,
        'max' => 255,
    ])]
    #[Choice([
        CryptocurrencyConfig::ACTIVE,
        CryptocurrencyConfig::NOT_ACTIVE
    ])]
    public string $status;
}