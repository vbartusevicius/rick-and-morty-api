<?php

declare(strict_types=1);

namespace DataFixtures\Helper;

use ReflectionClass;

class ReflectionHelper
{
    public static function setId(object $object, int $value): void
    {
        $reflection = new ReflectionClass($object);

        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }
}
