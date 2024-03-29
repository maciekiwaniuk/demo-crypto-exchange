<?php

namespace App\Tests\Tools;

use ReflectionClass;

class PrivateProperty
{
    public static function set($entity, $propertyName, $value): void
    {
        $class = new ReflectionClass($entity);
        $property = $class->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($entity, $value);
    }
}