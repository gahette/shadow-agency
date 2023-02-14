<?php

$id = (int)$params['id'];

use App\Model\Agents;
use App\Model\Contacts;
use App\Model\Countries;
use App\Model\Targets;
use App\URL;
use Database\DBConnection;


$db = new DBConnection();
$query = $db->getPDO()->prepare('SELECT * FROM nationalities WHERE nationalities_id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Countries::class);
$nationality = $query->fetch();

if ($nationality === false) {
    throw new Exception("Aucun pays ne correspond à cet ID");
}

$title = "Pays {$nationality->getNationalitiesName()}";

$currentPage = URL::getPositiveInt('page', 1);
$count = (int)$db->getPDO()
    ->query("SELECT COUNT('agents_id') FROM agents WHERE nationalities_nationalities_id=" . $nationality->getNationalitiesId())
    ->fetch(PDO::FETCH_NUM)[0];
$perPage = 20;
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}

$offset = $perPage * ($currentPage - 1);


$query = $db->getPDO()->query("
SELECT a.*
FROM agents a 
JOIN nationalities n on n.nationalities_id = a.nationalities_nationalities_id
WHERE nationalities_nationalities_id = {$nationality->getNationalitiesId()}
ORDER BY agents_id
LIMIT $perPage OFFSET $offset");
$agents = $query->fetchAll(PDO::FETCH_CLASS, Agents::class);

$query = $db->getPDO()->query("
SELECT t.*
FROM targets t 
JOIN nationalities n on n.nationalities_id = t.nationalities_nationalities_id
WHERE nationalities_nationalities_id = {$nationality->getNationalitiesId()}
ORDER BY targets_id
LIMIT $perPage OFFSET $offset");
$targets = $query->fetchAll(PDO::FETCH_CLASS, Targets::class);

$query = $db->getPDO()->query("
SELECT c.*
FROM contacts c
JOIN nationalities n on n.nationalities_id = c.nationalities_nationalities_id
WHERE nationalities_nationalities_id = {$nationality->getNationalitiesId()}
ORDER BY contacts_id
LIMIT $perPage OFFSET $offset");
$contacts = $query->fetchAll(PDO::FETCH_CLASS, Contacts::class);


?>

<h2><?= e($title) ?></h2>

<div class="row">
    <h3 class="m-3">Agents</h3>
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

<div class="row">
    <h3 class="m-3">Cibles</h3>
    <table class="table">

        <thead>
        <tr>
            <th scope="col"><h4>Code cibles</h4></h></th>
            <th scope="col"><h4>Noms</h4></th>
            <th scope="col"><h4>Prénoms</h4></th>
            <th scope="col"><h4>Date des naissances</h4></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($targets as $target): ?>
            <tr>
                <th scope="row"><h5><?= htmlentities($target->getTargetsId()) ?></h5></th>
                <td><h5><?= htmlentities($target->getTargetsLastname()) ?></h5></td>
                <td><?= nl2br(htmlentities($target->getTargetsFirstname())) ?></td>
                <td class="text-muted"><?= $target->getTargetsBod()->format('d/m/Y') ?></td>
                <td>
                    <a href="<?= $router->url('target', ['id' => $target->getTargetsId()]) ?>" class="btn btn-primary">voir
                        plus</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="row">
    <h3 class="m-3">Contacts</h3>
    <table class="table">

        <thead>
        <tr>
            <th scope="col"><h4>Code cibles</h4></h></th>
            <th scope="col"><h4>Noms</h4></th>
            <th scope="col"><h4>Prénoms</h4></th>
            <th scope="col"><h4>Date des naissances</h4></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <th scope="row"><h5><?= htmlentities($contact->getContactsId()) ?></h5></th>
                <td><h5><?= htmlentities($contact->getContactsLastname()) ?></h5></td>
                <td><?= nl2br(htmlentities($contact->getContactsFirstname())) ?></td>
                <td class="text-muted"><?= $contact->getContactsBod()->format('d/m/Y') ?></td>
                <td>
                    <a href="<?= $router->url('contact', ['id' => $contact->getContactsId()]) ?>"
                       class="btn btn-primary">voir
                        plus</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!--Pagination en bas-->
<!--<div class="d-flex justify-content-between my-4">-->
<!--    --><?php //if ($currentPage > 1): ?>
<!--        --><?php
//        $link = $router->url('nationality');
//        if ($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
//        ?>
<!--        <a href="--><?php //= $link ?><!--" class="btn btn-primary">&laquo; Page précédente </a>-->
<!--    --><?php //endif ?>
<!---->
<!--    --><?php //if ($currentPage < $pages): ?>
<!--        <a href="--><?php //= $router->url('nationality') ?><!--?page=--><?php //= $currentPage + 1 ?><!--" class="btn btn-primary ms-auto">Page-->
<!--            suivante-->
<!--            &raquo;</a>-->
<!--    --><?php //endif ?>
<!--</div>-->