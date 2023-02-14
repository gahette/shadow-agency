<?php

namespace App\Table;

use App\Model\Agents;
use App\Model\Countries;
use App\Model\Specialities;
use PDO;

final class AgentTable extends Table
{

    protected $table = "agents";
    protected $i = "agents_id";
    protected $class = Agents::class;

    public function hydrateAgents(array $agents): void
    {
        $agentsByID = [];
        foreach ($agents as $agent) {
            $agentsByID[$agent->getAgentsId()] = $agent;
        }

        $countries = $this->pdo->query('SELECT c.*, ac.agents_agents_id
 FROM agents_countries ac
 JOIN countries c on c.countries_id = ac.countries_countries_id
 WHERE ac.agents_agents_id IN (' . implode(',', array_keys($agentsByID)) . ')'
        )->fetchAll(PDO::FETCH_CLASS, Countries::class);
        foreach ($countries as $country) {
            $agentsByID[$country->getAgentsAgentsId()]->addCountry($country);
        }
        $specialities = $this->pdo->query('SELECT s.*, asp.agents_agents_id
 FROM agents_specialities asp
 JOIN specialities s on s.specialities_id = asp.specialities_specialities_id
 WHERE asp.agents_agents_id IN (' . implode(',', array_keys($agentsByID)) . ')'
        )->fetchAll(PDO::FETCH_CLASS, Specialities::class);
        foreach ($specialities as $speciality) {
            $agentsByID[$speciality->getAgentsAgentsId()]->addSpeciality($speciality);
        }
    }
}