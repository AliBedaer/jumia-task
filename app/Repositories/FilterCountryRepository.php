<?php


namespace App\Repositories;

use App\Abstracts\BaseRepository;
use App\DTOs\FilterCountriesDTO;
use App\Enums\CountriesCodesEnum;
use App\Enums\CountriesFilterRegexEnum;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use ReflectionException;

class FilterCountryRepository extends BaseRepository
{

    /**
     * FilterCountryRepository constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
    }


    /**
     * @desc the main function to fetch countries build the used regex and pass it to the baseQuery()
     * @return Builder
     * @throws ReflectionException
     */
    public function getAllCountries() : Builder
    {
        $regex = implode("|", CountriesFilterRegexEnum::getConstantsValues());
        return  $this->baseQuery($regex);
    }


    /**
     * @desc
     * @param FilterCountriesDTO $filterCountriesDTO
     * @return array|Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws ReflectionException
     */
    public function filteredCountries(FilterCountriesDTO $filterCountriesDTO)
    {
        $country = $filterCountriesDTO->getCountry(); // define the country from DTO
        $state = $filterCountriesDTO->getState(); // define the State from DTO

        //  build the regex if a specific country filter sent else execute all countries regex
        $regex = CountriesFilterRegexEnum::getConstantValue($filterCountriesDTO->getCountry()) ?? implode("|", CountriesFilterRegexEnum::getConstantsValues());

        //
        $countryCode = CountriesCodesEnum::getConstantValue($filterCountriesDTO->getCountry());


        $stateAppendCondition =  (isset($state) && $state != "") ?  '' : ' NOT ';

        $query = $this->baseQuery($regex);

        // state filter query
        if (isset($state)){
            $query = $query->whereRaw($stateAppendCondition . "regexp_like('/$regex/',phone)");
        }

        // country filter Query
        if (isset($country)) {
            $query = $query->where('phone', 'LIKE', '(' . $countryCode . ')%');
        }

        return $query;
    }

    /**
     * @desc list All | filter By Country | filter by Valid or not => all are share this query
     *  - this match the validity regex against the phone and return state
     *  - return the country based on the phone number
     * @param string $regex
     * @return Builder
     */
    private function baseQuery(string $regex) : Builder
    {
        return $this->query()
            ->select("*", DB::raw("CASE WHEN regexp_like('/$regex/',phone) THEN 'OK' ELSE 'NOK' END state"), DB::raw("getCountryCode(phone) as code"), DB::raw("getCountry(phone) as country"));
    }
}
