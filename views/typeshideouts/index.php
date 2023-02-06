<?php

use App\Model\Typeshideouts;
use App\URL;
use Database\DBConnection;

$title = 'Types de planques';

$db = new DBConnection();

//Variable page courante en appelant la class URL avec la méthode getPositiveInt
$currentPage = URL::getPositiveInt('page', 1);


//Récupération du nombre d'agents sous forme de tableau numérique avec seulement la premiere colonne
//forçage de type avec (int)
$count = (int)$db->getPDO()->query("SELECT COUNT('types_hideouts_id') FROM types_hideouts")->fetch(PDO::FETCH_NUM)[0];

//variable d'élément par page
$perPage = 12;

//calcul du nombre de pages
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}

//variable de l'offset
$offset = $perPage * ($currentPage - 1);


$query = $db->getPDO()->query("SELECT * FROM types_hideouts ORDER BY types_hideouts_name LIMIT $perPage OFFSET $offset");
$types_hideouts = $query->fetchAll(PDO::FETCH_CLASS, Typeshideouts::class);
?>


<h3>Les spécialités</h3>


<div class="row">
    <table class="table">

        <thead>
        <tr>
            <th scope="col"><h4>Code spécialité</h4></h></th>
            <th scope="col"><h4>Noms</h4></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($types_hideouts as $types_hideout): ?>
            <tr>
                <th scope="row"><h5><?= htmlentities($types_hideout->getTypesHideoutsId()) ?></h5></th>
                <td><h5><?= htmlentities($types_hideout->getTypesHideoutsName()) ?></h5></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!--Pagination en bas-->
<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1): ?>


        <?php
        $link = $router->url('typeshideouts');
        if ($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $link ?>" class="btn btn-primary">&laquo; Page précédente </a>
    <?php endif ?>

    <?php if ($currentPage < $pages): ?>
        <a href="<?= $router->url('typeshideouts') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ms-auto">Page
            suivante
            &raquo;</a>
    <?php endif ?>
</div>
