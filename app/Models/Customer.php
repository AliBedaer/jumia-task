<?php

namespace App\Models;

use App\Enums\CountriesCodesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{

    public function __construct()
    {
        if (DB::Connection() instanceof \Illuminate\Database\SQLiteConnection) {

            DB::connection()->getPdo()->sqliteCreateFunction("regexpLike", "preg_match", 2);

            DB::connection()->getPdo()->sqliteCreateFunction("getCountryCode", function ($phone) {
                preg_match('/\([0-9]{0,}\)/', $phone, $m);
                return $m[0];
            }, 1);

            DB::connection()->getPdo()->sqliteCreateFunction("getCountry", function ($phone) {
                preg_match('/\([0-9]{0,}\)/', $phone, $m);
                $code = str_replace(['(', ')'], '', $m[0]);
                return CountriesCodesEnum::GetCountryByCode($code);
            }, 1);
        }
    }


    protected $table = "customer";
}
