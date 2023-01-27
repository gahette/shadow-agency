<?php

use App\Model\Agents;
use Database\DBConnection;

$title = 'Dashboard';


$db = new DBConnection();


$page = $_GET['page'] ?? 1;

if(!filter_var($page, FILTER_VALIDATE_INT)){
    throw  new Exception('Numéro de page invalide');
}

if($page === '1'){
    header('Location: ' . $router->url('agents'));
    http_response_code(301);
    exit();
}

$currentPage = (int)$page;
if ($currentPage === 0) {
    throw new Exception('Numéro de page invalide');
}
$count = (int)$db->getPDO()->query("SELECT COUNT('agents_id') FROM agents")->fetch(PDO::FETCH_NUM)[0];
$perPage = 12;
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}
$offset = $perPage * ($currentPage - 1);
$query = $db->getPDO()->query("SELECT * FROM agents ORDER BY agents_lastname DESC LIMIT $perPage OFFSET $offset");
$agents = $query->fetchAll(PDO::FETCH_CLASS, Agents::class);
?>


<h1>Mes agents </h1>


<div class="row">
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