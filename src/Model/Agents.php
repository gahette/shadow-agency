<?php

namespace App\Model;


use DateTime;
use Exception;

class Agents
{
    private int $agents_id;
    private string $agents_lastname;
    private string $agents_firstname;
    private $agents_bod;

    private $countries = [];

    private $specialities = [];


    /**
     * @return int
     */
    public function getAgentsId(): int
    {
        return $this->agents_id;
    }

    /**
     * @return string
     */
    public function getAgentsLastname(): string
    {
        return $this->agents_lastname;
    }

    /**
     * @return string
     */
    public function getAgentsFirstname(): string
    {
        return $this->agents_firstname;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getAgentsBod(): DateTime
    {
        return new DateTime($this->agents_bod);
    }

    /**
     * @return array
     */
    public function getSpecialities(): array
    {
        return $this->specialities;
    }

    /**
     * @return array
     */
    public function getCountries(): array
    {
        return $this->countries;
    }

    public function addSpeciality(Specialities $specialities): void
    {
        $this->specialities[] = $specialities;
        $specialities->setAgentSpe($this);
    }

    public function addCountry(Countries $countries): void
    {
        $this->countries[] = $countries;
        $countries->setAgentNat($this);
    }

    /**
     * @param string $agents_lastname
     */
    public function setAgentsLastname(string $agents_lastname): void
    {
        $this->agents_lastname = $agents_lastname;
    }

    /**
     * @param string $agents_firstname
     */
    public function setAgentsFirstname(string $agents_firstname): void
    {
        $this->agents_firstname = $agents_firstname;
    }

    /**
     * @param mixed $agents_bod
     */
    public function setAgentsBod($agents_bod): void
    {
        $this->agents_bod = $agents_bod;
    }


}