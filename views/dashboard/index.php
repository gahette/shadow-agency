<?php

use App\Model\Agents;
use Database\DBConnection;

$title = 'Dashboard';


$db = new DBConnection();

$query = $db->getPDO()->query("SELECT * FROM agents ORDER BY agents_lastname DESC LIMIT 12");
$agents = $query->fetchAll(PDO::FETCH_CLASS,Agents::class);
?>


<h1>Mes agents </h1>


<div class="row">
    <?php foreach ($agents as $agent): ?>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlentities($agent->getAgentsLastname()) ?></h5>
                    <p><?= nl2br(htmlentities($agent->getAgentsFirstname())) ?></p>
                    <p class="text-muted"><?= $agent->getAgentsBod()->format('d/m/Y') ?></p>
                    <p>
                        <a href="#" class="btn btn-primary">voir plus</a>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>



