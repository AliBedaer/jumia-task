<?php

namespace App\Enums;


class CountriesCodesEnum extends BaseEnum
{
    public const CAMEROON   = 237;
    public const ETHIOPIA   = 251;
    public const MOROCCO    = 212;
    public const MOZAMBIQUE = 258;
    public const UGANDA     = 256;

    /**
     * @return string[]
     */
    public static function GetCountriesArray() : array
    {
        return [
            "Cameroon",
            "Ethiopia",
            "Morocco",
            "Mozambique",
            "Uganda"
        ];
    }

    /**
     * @param $code
     * @return int|string
     */
    public static function GetCountryByCode($code)
    {
        return array_flip(self::getConstants())[$code];
    }
}
