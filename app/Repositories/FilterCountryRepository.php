<?php


namespace App\Repositories;

use App\Abstracts\BaseRepository;
use App\DTOs\FilterCountriesDTO;
use App\Enums\CountriesCodesEnum;
use App\Enums\CountriesFilterRegexEnum;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
     * @return Builder
     * @throws \ReflectionException
     */
    public function getAllCountries() : Builder
    {
        $regex = implode("|", CountriesFilterRegexEnum::getConstantsValues());
        $query = $this->baseQuery($regex);
        return $query;
    }


    /**
     * @param FilterCountriesDTO $filterCountriesDTO
     * @return array|Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function filteredCountries(FilterCountriesDTO $filterCountriesDTO)
    {
        $country = $filterCountriesDTO->getCountry();
        $state = $filterCountriesDTO->getState();

        $query = $this->query();

        $regex = CountriesFilterRegexEnum::getConstantValue($filterCountriesDTO->getCountry()) ?? implode("|", CountriesFilterRegexEnum::getConstantsValues());


        $countryCode = CountriesCodesEnum::getConstantValue($filterCountriesDTO->getCountry());

        $stateAppendCondition =  (isset($state) && $state != "") ?  '' : ' NOT ';
        $query = $this->baseQuery($regex);

        if (isset($state)){
            $query = $query->whereRaw($stateAppendCondition . "regexp_like('/$regex/',phone)");
        }

        if (isset($country)) {
            $query = $query->where('phone', 'LIKE', '(' . $countryCode . ')%');
        }

        return $query;
    }

    private function baseQuery(string $regex) : Builder
    {
        return $this->query()->select("*", DB::raw("CASE WHEN regexp_like('/$regex/',phone) THEN 'OK' ELSE 'NOK' END state"), DB::raw("getCountryCode(phone) as code"), DB::raw("getCountry(phone) as country"));;
    }
}
