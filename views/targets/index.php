<?php

use App\Model\Targets;
use App\PaginatedQuery;
use App\URL;
use Database\DBConnection;

$title = 'Cibles';

$pdo = new DBConnection();

$paginatedQuery = new PaginatedQuery(
        'SELECT *
FROM targets
ORDER BY targets_lastname',
"SELECT COUNT('targets_id') FROM targets"
);

$targets = $paginatedQuery->getItems(Targets::class);

$link = $router->url('targets');

?>

<h3>Les cibles</h3>


<div class="row">
    <?php foreach ($targets as $target): ?>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= e($target->getTargetsLastname()) ?></h5>
                    <p><?= nl2br(e($target->getTargetsFirstname())) ?></p>
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
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>