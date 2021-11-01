<?php

namespace App\Enums;

use ReflectionClass;

class BaseEnum
{

    /**
     * @return array
     * @throws \ReflectionException
     */
    static function getConstants(): array
    {
        // instantiate ReflectionClass for enum class
        $enumReflection = new ReflectionClass(get_called_class());

        // return array of names for all constants for current enum
        return $enumReflection->getConstants();
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function getConstantsValues(): array
    {
        $constants = self::getConstants();
        return array_values($constants);
    }


    /**
     * @param $value
     * @return mixed|null
     * @throws \ReflectionException
     */
    public static function getConstantValue($value)
    {
        $constants = self::getConstants();
        return $constants[strtoupper(str_replace(' ', '_', $value))] ?? null;
    }
}
