<?php

namespace App\Http\Controllers;

use App\DTOs\FilterCountriesDTO;
use App\Resources\FilterCountriesResource;
use App\Services\FilterService;
use Illuminate\Support\Facades\Log;
use ReflectionException;


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
     * @desc validate the request inputs and if valid filter and return resource collection
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function filter()
    {
        $validateErrors = $this->filterService->validateRequest(request());

        if (!is_null($validateErrors)) {
            return response()->json(["errors" => $validateErrors], 422);
        }

        try {
            return FilterCountriesResource::collection($this->filterService->filter());
        } catch (ReflectionException $e) {
            Log::debug("Failed To Filter", [
                "message" => $e->getMessage(),
                "file" => $e->getFile(),
                "Line" => $e->getLine()
            ]);
            return response()->json(["errors" => "Failed To Filter"], 422);
        }

    }
}
