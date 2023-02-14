<?php

namespace App\Model;

class Specialities
{
private int $specialities_id;
private string $specialities_name;

private int $agents_agents_id;

private $agent_spe;


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

    /**
     * @return int
     */
    public function getAgentsAgentsId(): int
    {
        return $this->agents_agents_id;
    }

    /**
     * @param mixed $agent_spe
     */
    public function setAgentSpe(Agents $agent_spe): void
    {
        $this->agent_spe = $agent_spe;
    }



}