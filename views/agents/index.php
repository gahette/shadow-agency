<?php

use App\Auth;
use App\Table\AgentsTable;
use Database\DBConnection;


Auth::check();

$title = 'Agents';


$pdo = new DBConnection();
$link = $router->url('agents');
$table = new AgentsTable($pdo->getPDO()); //instance de PDO dans DBConnection.php
[$agents, $pagination] = $table->findPaginated();

?>

<h3>Mes agents</h3>

<?php
if (isset($_GET['delete'])) ?>
<div class="alert alert-success">
    L'enregistrement a bien été supprimé
</div>

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

                <td><a href="<?= $router->url('show', ['id' => $agent->getAgentsId()]) ?>" class="btn btn-info">voir
                    </a>
                </td>
                <td><a href="<?= $router->url('agents_edit', ['id' => $agent->getAgentsId()]) ?>"
                       class="btn btn-warning">Editer
                    </a>
                </td>
                <td>
                    <form action="<?= $router->url('agents_delete', ['id' => $agent->getAgentsId()]) ?>"
                          method="post"
                          onclick="return confirm('Voulez-vous vraiment effectuer cette action ?')">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
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