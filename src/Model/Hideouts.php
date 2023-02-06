<?php

namespace App\Model;

class Hideouts
{
    private $hideouts_id;
    private $hideouts_address;

    private array $nationalities = [];

    /**
     * @return mixed
     */
    public function getHideoutsId()
    {
        return $this->hideouts_id;
    }

    /**
     * @return mixed
     */
    public function getHideoutsAddress()
    {
        return $this->hideouts_address;
    }

}