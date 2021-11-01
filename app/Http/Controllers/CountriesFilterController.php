<?php

namespace App\Http\Controllers;

use App\DTOs\FilterCountriesDTO;
use App\Models\Customer;
use App\Resources\FilterCountriesResource;
use App\Services\FilterService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CountriesFilterController extends Controller
{

    public FilterService $filterService;
    public FilterCountriesDTO $filterCountriesDTO;

    /**
     * CountriesFilterController constructor.
     * @param FilterService $filterService
     * @param FilterCountriesDTO $filterCountriesDTO
     */
    public function __construct(FilterService $filterService, FilterCountriesDTO $filterCountriesDTO)
    {
        $this->filterService = $filterService;
        $this->filterCountriesDTO = $filterCountriesDTO;
    }


    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function filter()
    {
        $validateErrors = $this->filterService->validateRequest(request());

        if (!is_null($validateErrors)) {
            return response()->json(["errors" => $validateErrors], 422);
        }

        return FilterCountriesResource::collection($this->filterService->filter());

    }
}
