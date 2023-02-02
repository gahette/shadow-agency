<?php

use App\Model\Targets;
use App\URL;
use Database\DBConnection;

$title = 'Cibles';

$db = new DBConnection();

//Variable page courante en appelant la class URL avec la méthode getPositiveInt
$currentPage = URL::getPositiveInt('page', 1);


//Récupération du nombre d'agents sous forme de tableau numérique avec seulement la premiere colonne
//forçage de type avec (int)
$count = (int)$db->getPDO()->query("SELECT COUNT('targets_id') FROM agents")->fetch(PDO::FETCH_NUM)[0];

//variable d'élément par page
$perPage = 12;

//calcul du nombre de pages
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}

//variable de l'offset
$offset = $perPage * ($currentPage - 1);


$query = $db->getPDO()->query("SELECT * FROM targets ORDER BY targets_lastname LIMIT $perPage OFFSET $offset");
$targets = $query->fetchAll(PDO::FETCH_CLASS, Targets::class);
?>


<h3>Les cibles</h3>


<div class="row">
    <?php foreach ($targets as $target): ?>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlentities($target->getTargetsLastname()) ?></h5>
                    <p><?= nl2br(htmlentities($target->getTargetsFirstname())) ?></p>
                    <p class="text-muted"><?= $target->getTargetsBod()->format('d/m/Y') ?></p>
                    <p>
                        <a href="<?= $router->url('target', ['id' => $target->getTargetsId()]) ?>" class="btn btn-primary">voir
                            plus</a>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
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
        <a href="<?= $router->url('targets') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ms-auto">Page
            suivante
            &raquo;</a>
    <?php endif ?>
