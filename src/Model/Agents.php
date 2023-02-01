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

private array $nationalities = [];

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

    public function getAgentsBod(): DateTime
    {
        return new DateTime($this->agents_bod);
    }

}