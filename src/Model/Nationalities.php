<?php

namespace App\Model;

class Nationalities
{
    private int $nationalities_id;
    private string $nationalities_name;

    /**
     * @return int
     */
    public function getNationalitiesId(): int
    {
        return $this->nationalities_id;
    }

    /**
     * @return string
     */
    public function getNationalitiesName(): string
    {
        return $this->nationalities_name;
    }

}