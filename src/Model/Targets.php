<?php

namespace App\Model;


use DateTime;
use Exception;

class Targets
{
    private int $targets_id;
    private string $targets_lastname;
    private string $targets_firstname;
    private $targets_bod;
    private string $targets_nickname;


    private array $nationalities = [];

    /**
     * @return int
     */
    public function getTargetsId(): int
    {
        return $this->targets_id;
    }

    /**
     * @return string
     */
    public function getTargetsLastname(): string
    {
        return $this->targets_lastname;
    }

    /**
     * @return string
     */
    public function getTargetsFirstname(): string
    {
        return $this->targets_firstname;
    }

    public function getTargetsBod(): DateTime
    {
        return new DateTime($this->targets_bod);
    }

    /**
     * @return string
     */
    public function getTargetsNickname(): string
    {
        return $this->targets_nickname;
    }

}