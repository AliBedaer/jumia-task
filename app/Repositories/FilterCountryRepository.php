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

    private ?string $state;
    private ?string $regex;
    private ?string $countryCode;
    private ?string $country;

    /**
     * FilterCountryRepository constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
    }


    /**
     * @desc the main function to fetch countries and build the used regex and pass it to the baseQuery()
     * @return Builder
     * @throws ReflectionException
     */
    public function getAllCountries(): Builder
    {
        $regex = implode("|", CountriesFilterRegexEnum::getConstantsValues());
        return $this->baseQuery($regex);
    }


    /**
     * @desc filter only by validity either valid or invalid
     * @param FilterCountriesDTO $filterCountriesDTO
     * @return Builder
     */
    public function filterByValidity(FilterCountriesDTO $filterCountriesDTO): Builder
    {

        $this->sharedBetweenFilter($filterCountriesDTO);

        $stateAppendCondition = $this->state == "invalid" ? ' NOT ' : '';

        $query = $this->baseQuery($this->regex);

        if (isset($this->state)) {
            $query = $query->whereRaw($stateAppendCondition . "regexpLike('/$this->regex/',phone)");
        }

        return $query;
    }


    /**
     * @desc filter only by country
     * @param FilterCountriesDTO $filterCountriesDTO
     * @return Builder
     */
    public function filterByCountry(FilterCountriesDTO $filterCountriesDTO): Builder
    {
        $this->sharedBetweenFilter($filterCountriesDTO);

        $query = $this->baseQuery($this->regex);


        if (isset($this->country) && !empty($this->country)) {
            $query = $query->where('phone', 'LIKE', '(' . $this->countryCode . ')%');
        }

        return $query;
    }


    /**
     * @desc when filter by both country and validity
     * @param FilterCountriesDTO $filterCountriesDTO
     * @return Builder
     * @throws ReflectionException
     */
    public function filterByCountryAndValidity(FilterCountriesDTO $filterCountriesDTO): Builder
    {
        $this->sharedBetweenFilter($filterCountriesDTO);

        $query = $this->baseQuery($this->regex);


        $stateAppendCondition = $this->state == "invalid" ? ' NOT ' : '';


        if (!empty($this->state)) {

            $query = $query->whereRaw($stateAppendCondition . "regexpLike('/$this->regex/',phone)");
        }


        if (!empty($this->country)) {
            $query = $query->where('phone', 'LIKE', '(' . $this->countryCode . ')%');
        }

        return $query;

    }


    /**
     * @desc set all shared queries and variable for search
     * @param FilterCountriesDTO $filterCountriesDTO
     * @throws ReflectionException
     */
    private function sharedBetweenFilter(FilterCountriesDTO $filterCountriesDTO)
    {
        $this->state = $filterCountriesDTO->getState();

        $this->regex = CountriesFilterRegexEnum::getConstantValue($filterCountriesDTO->getCountry()) ?? implode("|", CountriesFilterRegexEnum::getConstantsValues());

        $this->countryCode = CountriesCodesEnum::getConstantValue($filterCountriesDTO->getCountry());

        $this->country = $filterCountriesDTO->getCountry();
    }


    /**
     * @desc list All | filter By Country | filter by Valid or not => all are share this query
     *  - this match the validity regex against the phone and return state
     *  - return the country based on the phone number
     * @param string $regex
     * @return Builder
     */
    private function baseQuery(string $regex): Builder
    {
        return $this->query()
            ->select("*", DB::raw("CASE WHEN regexpLike('/$regex/',phone) THEN 'OK' ELSE 'NOK' END state"), DB::raw("getCountryCode(phone) as code"), DB::raw("getCountry(phone) as country"));
    }
}
