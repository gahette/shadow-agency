<?php

$id = (int)$params['id'];

use App\Model\Agents;
use App\Model\Contacts;
use App\Model\Nationalities;
use App\Model\Targets;
use App\URL;
use Database\DBConnection;


$db = new DBConnection();
$query = $db->getPDO()->prepare('SELECT * FROM nationalities WHERE nationalities_id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Nationalities::class);
$nationality = $query->fetch();

if ($nationality === false) {
    throw new Exception("Aucun pays ne correspond à cet ID");
}

$title = "Pays {$nationality->getNationalitiesName()}";

$currentPage = URL::getPositiveInt('page', 1);
$count = (int)$db->getPDO()
    ->query("SELECT COUNT('agents_id') FROM agents WHERE nationalities_nationalities_id=" . $nationality->getNationalitiesId())
    ->fetch(PDO::FETCH_NUM)[0];
$perPage = 12;
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
ORDER BY agents_lastname
LIMIT $perPage OFFSET $offset");
$agents = $query->fetchAll(PDO::FETCH_CLASS, Agents::class);

$query = $db->getPDO()->query("
SELECT t.*
FROM targets t 
JOIN nationalities n on n.nationalities_id = t.nationalities_nationalities_id
WHERE nationalities_nationalities_id = {$nationality->getNationalitiesId()}
ORDER BY targets_lastname
LIMIT $perPage OFFSET $offset");
$targets = $query->fetchAll(PDO::FETCH_CLASS, Targets::class);

$query = $db->getPDO()->query("
SELECT c.*
FROM contacts c
JOIN nationalities n on n.nationalities_id = c.nationalities_nationalities_id
WHERE nationalities_nationalities_id = {$nationality->getNationalitiesId()}
ORDER BY contacts_lastname
LIMIT $perPage OFFSET $offset");
$contacts = $query->fetchAll(PDO::FETCH_CLASS, Contacts::class);
?>

<h3><?= e($title) ?></h3>

<div class="row">
    <h4 class="m-3">Agents</h4>
    <?php foreach ($agents as $agent): ?>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlentities($agent->getAgentsLastname()) ?></h5>
                    <p><?= nl2br(htmlentities($agent->getAgentsFirstname())) ?></p>
                    <p class="text-muted"><?= $agent->getAgentsBod()->format('d/m/Y') ?></p>
                    <p>
                        <a href="<?= $router->url('show', ['id' => $agent->getAgentsId()]) ?>" class="btn btn-primary">voir
                            plus</a>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <h4 class="m-3">Cibles</h4>
    <?php foreach ($targets as $target): ?>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlentities($target->getTargetsLastname()) ?></h5>
                    <p><?= nl2br(htmlentities($target->getTargetsFirstname())) ?></p>
                    <p class="text-muted"><?= $target->getTargetsBod()->format('d/m/Y') ?></p>
                    <p>
                        <a href="<?= $router->url('target', ['id' => $target->getTargetsId()]) ?>"
                           class="btn btn-primary">voir
                            plus</a>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <h4 class="m-3">Contacts</h4>
    <?php foreach ($contacts as $contact): ?>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlentities($contact->getContactsLastname()) ?></h5>
                    <p><?= nl2br(htmlentities($contact->getContactsFirstname())) ?></p>
                    <p class="text-muted"><?= $contact->getContactsBod()->format('d/m/Y') ?></p>
                    <p>
                        <a href="<?= $router->url('contact', ['id' => $contact->getContactsId()]) ?>" class="btn btn-primary">voir
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
        <a href="<?= $router->url('agents') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ms-auto">Page
            suivante
            &raquo;</a>
    <?php endif ?>
</div>