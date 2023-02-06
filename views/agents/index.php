<?php

use App\Model\Agents;
use App\URL;
use Database\DBConnection;

$title = 'Agents';

$db = new DBConnection();

//Variable page courante en appelant la class URL avec la méthode getPositiveInt
$currentPage = URL::getPositiveInt('page', 1);


//Récupération du nombre d'agents sous forme de tableau numérique avec seulement la premiere colonne
//forçage de type avec (int)
$count = (int)$db->getPDO()->query("SELECT COUNT('agents_id') FROM agents")->fetch(PDO::FETCH_NUM)[0];

//variable d'élément par page
$perPage = 12;

//calcul du nombre de pages
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}

//variable de l'offset
$offset = $perPage * ($currentPage - 1);


$query = $db->getPDO()->query("SELECT * FROM agents ORDER BY agents_lastname LIMIT $perPage OFFSET $offset");
$agents = $query->fetchAll(PDO::FETCH_CLASS, Agents::class);
?>


<h3>Mes agents</h3>


<div class="row">
    <table class="table">

        <thead>
        <tr>
            <th scope="col"><h4>Code agents</h4></h></th>
            <th scope="col"><h4>Noms</h4></th>
            <th scope="col"><h4>Prénoms</h4></th>
            <th scope="col"><h4>Date des naissances</h4></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($agents as $agent): ?>
            <tr>
                <th scope="row"><h5><?= htmlentities($agent->getAgentsId()) ?></h5></th>
                <td><h5><?= htmlentities($agent->getAgentsLastname()) ?></h5></td>
                <td><?= nl2br(htmlentities($agent->getAgentsFirstname())) ?></td>
                <td class="text-muted"><?= $agent->getAgentsBod()->format('d/m/Y') ?></td>
                <td>
                    <a href="<?= $router->url('show', ['id' => $agent->getAgentsId()]) ?>" class="btn btn-primary">voir
                        plus</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!--Pagination en bas-->
<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1): ?>


        <?php
        $link = $router->url('agents');
        if ($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $link ?>" class="btn btn-primary">&laquo; Page précédente </a>
    <?php endif ?>

    <?php if ($currentPage < $pages): ?>
        <a href="<?= $router->url('agents') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ms-auto">Page
            suivante
            &raquo;</a>
    <?php endif ?>
</div>