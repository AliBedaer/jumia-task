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
    private ?bool $state;


    public function setCountry(?string $country)
    {
        $this->country = $country;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setState(?bool $state)
    {
        $this->state = $state;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

}
