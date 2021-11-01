<?php


namespace App\Services;

use App\DTOs\FilterCountriesDTO;
use App\Enums\CountriesCodesEnum;
use App\Repositories\FilterCountryRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;

class FilterService
{
    private FilterCountriesDTO $filterCountriesDTO;
    private FilterCountryRepository $filterCountryRepository;


    /**
     * FilterService constructor.
     * @param FilterCountriesDTO $filterCountriesDTO
     * @param FilterCountryRepository $filterCountryRepository
     */
    public function __construct(FilterCountriesDTO $filterCountriesDTO, FilterCountryRepository $filterCountryRepository)
    {
        $this->filterCountriesDTO = $filterCountriesDTO;
        $this->filterCountryRepository = $filterCountryRepository;
    }


    /**
     * @desc validate the request input in case filter sent
     * @param Request $request
     * @return MessageBag|null
     */
    public function validateRequest(Request $request): ?MessageBag
    {

        $validator = Validator::make($request->all(), [
            "country" => Rule::in(CountriesCodesEnum::GetCountriesArray()),
            "state" =>  "boolean"
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return null;
    }


    /**
     * * @desc if the request contain filter inputs will filter based on this inputs
     * else will return all the records paginated
     * @return LengthAwarePaginator
     * @throws \ReflectionException
     */
    public function filter() : LengthAwarePaginator
    {
        if (count(request()->all()) > 0) {
            return $this->filterData($this->filterCountriesDTO);
        }

        return $this->filterCountryRepository->getAllCountries()->paginate(env("PAGINATION_LIMIT",10));
    }


    /**
     * @desc map the request data to the DTO( Data Transfer Object )
     * @param array $data
     */
    private function setFilterCountriesDto(array $data)
    {
        $this->filterCountriesDTO->setCountry($data["country"] ?? null);
        $this->filterCountriesDTO->setState($data["state"] ?? null);
    }


    /**
     * @desc in case filter params are sent this will call filterCountriesDTO to map request
     * and pass it to filteredCountries() Function to filter based on it
     * @param FilterCountriesDTO $filterCountriesDTO
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filterData(FilterCountriesDTO $filterCountriesDTO) : LengthAwarePaginator
    {
        $this->setFilterCountriesDto(request()->all());

        return $this->filterCountryRepository->filteredCountries($filterCountriesDTO)->paginate(env("PAGINATION_LIMIT"));
    }
}
