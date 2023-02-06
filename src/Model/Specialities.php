<?php

namespace App\Model;

class Specialities
{
private int $specialities_id;
private string $specialities_name;

    /**
     * @return int
     */
    public function getSpecialitiesId(): int
    {
        return $this->specialities_id;
    }

    /**
     * @return string
     */
    public function getSpecialitiesName(): string
    {
        return $this->specialities_name;
    }




}