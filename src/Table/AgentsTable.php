<?php

namespace App\Table;

use App\Model\Agents;
use App\PaginatedQuery;
use Exception;


final class AgentsTable extends Table
{

    protected $table = "agents";
    protected $class = Agents::class;
    protected $i = "agents_id";

    /**
     * @throws Exception
     */
    public function update(Agents $agent ):void
    {
        $query = $this->pdo->prepare(sprintf("UPDATE %s SET %s.agents_lastname = :lastname, %s.agents_firstname = :firstname, %s.agents_bod = :bod WHERE %s.agents_id = :id", $this->table, $this->table, $this->table, $this->table, $this->table));
        $ok=$query->execute([
            'id'=>$agent->getAgentsId(),
            'lastname'=>$agent->getAgentsLastname(),
            'firstname'=>$agent->getAgentsFirstname(),
            'bod'=>$agent->getAgentsBod()->format('Y-m-d H:i:s')

        ]);
        if ($ok === false){
            throw new Exception(sprintf("Impossible de modifier l'enregistrement dans la table %s", $this->table));
        }
    }

    /**
     * @throws Exception
     */
    public function delete(int $id):void
    {
        $query = $this->pdo->prepare(sprintf("DELETE FROM %s WHERE %s_id = ?", $this->table, $this->table));
        $ok=$query->execute([$id]);
        if ($ok === false){
            throw new Exception("Impossible de supprimer l'enregistrement " . $id . " dans la table " . $this->table);
        }
    }

    /**
     * @throws Exception
     */
    public function findPaginated(): array
    {
        $paginatedQuery = new PaginatedQuery(
            sprintf("SELECT * FROM %s ORDER BY %s.agents_lastname", $this->table, $this->table),
            sprintf("SELECT COUNT('agents_id') FROM %s", $this->table),
            $this->pdo
        );
        $agents = $paginatedQuery->getItems(Agents::class);
        (new AgentTable($this->pdo))->hydrateAgents($agents);

        return [$agents, $paginatedQuery];
    }

}