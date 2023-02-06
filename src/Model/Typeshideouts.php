<?php

namespace App\Model;

class Typeshideouts
{
private int $types_hideouts_id;
private string $types_hideouts_name;

    /**
     * @return int
     */
    public function getTypesHideoutsId(): int
    {
        return $this->types_hideouts_id;
    }

    /**
     * @return string
     */
    public function getTypesHideoutsName(): string
    {
        return $this->types_hideouts_name;
    }



}