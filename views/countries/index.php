<?php


use App\Model\Countries;
use App\URL;
use Database\DBConnection;

$title = 'Pays';

$db = new DBConnection();

//Variable page courante en appelant la class URL avec la méthode getPositiveInt
$currentPage = URL::getPositiveInt('page', 1);


//Récupération du nombre d'agents sous forme de tableau numérique avec seulement la premiere colonne
//forçage de type avec (int)
$count = (int)$db->getPDO()->query("SELECT COUNT('nationalities_id') FROM nationalities")->fetch(PDO::FETCH_NUM)[0];

//variable d'élément par page
$perPage = 12;

//calcul du nombre de pages
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}

//variable de l'offset
$offset = $perPage * ($currentPage - 1);


$query = $db->getPDO()->query("SELECT * FROM nationalities ORDER BY nationalities_name LIMIT $perPage OFFSET $offset");
$nationalities = $query->fetchAll(PDO::FETCH_CLASS, Countries::class);
?>


<h2>Pays </h2>


<div class="row">
    <?php foreach ($nationalities as $nationality): ?>
        <div>
            <div class="list-group">
                <h5 class="list-group-item d-flex justify-content-between"><?= htmlentities($nationality->getNationalitiesName()) ?>
                    <a href="<?= $router->url('nationality', ['id' => $nationality->getNationalitiesId()]) ?>"
                       class="btn btn-primary">Détails</a></h5>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<!--Pagination en bas-->
<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1): ?>


        <?php
        $link = $router->url('nationalities');
        if ($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $link ?>" class="btn btn-primary">&laquo; Page précédente </a>
    <?php endif ?>

    <?php if ($currentPage < $pages): ?>
        <a href="<?= $router->url('nationalities') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ms-auto">Page
            suivante
            &raquo;</a>
    <?php endif ?>
</div>