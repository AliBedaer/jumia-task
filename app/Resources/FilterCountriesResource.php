<?php


namespace App\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class FilterCountriesResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "phone" => $this->phone,
            "state" => $this->state,
            "code" => $this->code,
            "country" => $this->country
        ];
    }
}
