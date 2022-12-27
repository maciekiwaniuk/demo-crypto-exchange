<?php

namespace App\Constraint;

use App\Entity\User;
use Symfony\Component\Validator\Constraint;

class UniqueValueInEntity extends Constraint
{
    public $message = 'There is already registered user with that email.';
    public $entityClass = '';
    public $field = '';

    public function getRequiredOptions(): array
    {
        return ['entityClass', 'field'];
    }

    public function getTargets(): array|string
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return get_class($this).'Validator';
    }
}