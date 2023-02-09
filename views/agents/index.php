<?php

use App\Model\Agents;
use App\Model\Nationalities;
use App\PaginatedQuery;
use Database\DBConnection;

$title = 'Agents';

$pdo = new DBConnection();

$paginatedQuery = new PaginatedQuery(
    "SELECT *
FROM agents
ORDER BY agents_lastname",
    "SELECT COUNT('agents_id') FROM agents"
);
$agents = $paginatedQuery->getItems(Agents::class);

$link = $router->url('agents');
?>


<h3>Mes agents</h3>


<div class="row">
    <table class="table">

        <thead>
        <tr>
            <th scope="col"><h4>Code agents</h4></h></th>
            <th scope="col"><h4>Noms</h4></th>
            <th scope="col"><h4>Prénoms</h4></th>
            <th scope="col"><h4>Né le</h4></th>
            <th scope="col"><h4>Nationalité</h4></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($agents as $agent): ?>
            <tr>
                <td><?= '# ' . e($agent->getAgentsId()) ?></td>
                <td><?= e($agent->getAgentsLastname()) ?></td>
                <td><?= e($agent->getAgentsFirstname()) ?></td>
                <td class="text-muted"><?= $agent->getAgentsBod()->format('d/m/Y') ?></td>
                <td>

                <td>
                    <a href="<?= $router->url('show', ['id' => $agent->getAgentsId()]) ?>" class="btn btn-primary">voir
                        plus</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>

<!--Pagination en bas-->
<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>