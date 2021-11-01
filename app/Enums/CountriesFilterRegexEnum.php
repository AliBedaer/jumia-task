<?php

namespace App\Enums;

class CountriesFilterRegexEnum extends BaseEnum
{
    public const CAMEROON   = "\(237\)\ ?[2368]\d{7,8}$";
    public const ETHIOPIA   = "\(251\)\ ?[1-59]\d{8}$";
    public const MOROCCO    = "\(212\)\ ?[5-9]\d{8}$";
    public const MOZAMBIQUE = "\(258\)\ ?[28]\d{7,8}$";
    public const UGANDA     = "\(256\)\ ?\d{9}$";
}
