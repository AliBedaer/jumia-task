<?php


namespace App\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class FilterCountriesResource extends JsonResource
{
    public function toArray($request)
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
