<?php

use App\Table\AgentsTable;
use Database\DBConnection;

$title = 'Agents';


$pdo = new DBConnection();

$table = new AgentsTable($pdo->getPDO()); //instance de PDO dans DBConnection.php
[$agents, $pagination] = $table->findPaginated();


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
            <th scope="col"><h4>Dates de naissance</h4></th>
            <th scope="col"><h4>Nationalités</h4></th>
            <th scope="col"><h4>Spécialités</h4></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($agents as $agent): ?>

            <tr>
                <td><?= '# ' . e($agent->getAgentsId()) ?></td>
                <td><?= e($agent->getAgentsLastname()) ?></td>
                <td><?= e($agent->getAgentsFirstname()) ?></td>
                <td><?= $agent->getAgentsBod()->format('d/m/Y') ?></td>
                <td>
                    <?php foreach ($agent->getCountries() as $country): ?>
                        <?= e($country->getNationalitiesName()) ?>
                    <?php endforeach; ?>
                </td>
                <td>
                    <?php foreach ($agent->getSpecialities() as $speciality): ?>
                        <?= e($speciality->getSpecialitiesName()) ?>,
                    <?php endforeach; ?>
                </td>

                <td><a href="<?= $router->url('show', ['id' => $agent->getAgentsId()]) ?>" class="btn btn-primary">voir
                        plus</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>

<!--Pagination en bas-->
<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>