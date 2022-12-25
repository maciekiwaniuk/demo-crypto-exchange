<?php

namespace App\Constraint;

use App\Entity\User;
use Symfony\Component\Validator\Constraint;

#[\Attribute] class UniqueValueInEntity extends Constraint
{
    public $message = 'There is already registered user with that email.';
    public $entityClass = '';
    public $field = '';

    public function getRequiredOptions()
    {
        return ['entityClass', 'field'];
    }

    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}