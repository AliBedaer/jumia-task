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
            "state" => Rule::in(["valid", "invalid"]),
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
    public function filter(): LengthAwarePaginator
    {
        if (count(request()->all()) > 0) {
            // in case all key sent but empty return all data
            return $this->filterData() ?? $this->filterCountryRepository->getAllCountries()->paginate(env("PAGINATION_LIMIT", 10));
        }

        return $this->filterCountryRepository->getAllCountries()->paginate(env("PAGINATION_LIMIT", 10));
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
     * @desc filter based on sent parameter and return null in case all sent but null
     * @return LengthAwarePaginator
     */
    private function filterData(): ?LengthAwarePaginator
    {
        $this->setFilterCountriesDto(request()->all());

        $country = $this->filterCountriesDTO->getCountry();
        $state = $this->filterCountriesDTO->getState();


        if (!empty($country) && empty($state)) {
            return $this->filterCountryRepository->filterByCountry($this->filterCountriesDTO)->paginate(env("PAGINATION_LIMIT"));
        }

        if (!empty($state) && empty($country)) {
            return $this->filterCountryRepository->filterByValidity($this->filterCountriesDTO)->paginate(env("PAGINATION_LIMIT"));
        }

        if (!empty($state) && !empty($country)) {
            return $this->filterCountryRepository->filterByCountryAndValidity($this->filterCountriesDTO)->paginate(env("PAGINATION_LIMIT"));
        }

        return null;
    }
}
