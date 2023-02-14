<?php

namespace App\Table;

use App\Model\Agents;
use App\PaginatedQuery;


final class AgentsTable extends Table
{

    protected $table = "agents";
    protected $class = Agents::class;
    protected $i = "agents_id";

    /**
     * @throws \Exception
     */
    public function findPaginated(): array
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM agents ORDER BY agents_lastname",
            "SELECT COUNT('agents_id') FROM agents",
            $this->pdo
        );
        $agents = $paginatedQuery->getItems(Agents::class);
        (new AgentTable($this->pdo))->hydrateAgents($agents);

        return [$agents, $paginatedQuery];
    }

}