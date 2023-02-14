<?php

namespace App\Model;

class Countries
{
    private int $countries_id;
    private string $countries_name;

    private string $nationalities_name;

    private string $countries_iso3166;

    private int $agents_agents_id;

    private $agent_nat;


    /**
     * @return int
     */
    public function getCountriesId(): int
    {
        return $this->countries_id;
    }

    /**
     * @return string
     */
    public function getCountriesName(): string
    {
        return $this->countries_name;
    }

    /**
     * @return string
     */
    public function getNationalitiesName(): string
    {
        return $this->nationalities_name;
    }

    /**
     * @return string
     */
    public function getCountriesIso3166(): string
    {
        return $this->countries_iso3166;
    }

    /**
     * @return int
     */
    public function getAgentsAgentsId(): int
    {
        return $this->agents_agents_id;
    }

    /**
     * @param mixed $agent_nat
     */
    public function setAgentNat(Agents $agent_nat): void
    {
        $this->agent_nat = $agent_nat;
    }


}