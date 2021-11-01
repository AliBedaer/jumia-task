<?php

namespace App\DTOs;

class FilterCountriesDTO
{
    /**
     * @var string $country
     */
    private ?string $country;

    /**
     * @var bool $state
     */
    private ?string $state;


    public function setCountry(?string $country)
    {
        $this->country = $country;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setState(?string $state)
    {
        $this->state = $state;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

}
