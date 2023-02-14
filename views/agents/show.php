<?php
$id = (int)$params['id'];

use App\Model\Agents;
use App\Model\Countries;
use App\Model\Specialities;
use App\Table\AgentsTable;
use App\Table\AgentTable;
use Database\DBConnection;



$pdo = new DBConnection();

$agent = (new AgentTable($pdo->getPDO()))->find($id);
(new AgentTable($pdo->getPDO()))->hydrateAgents([$agent]);

$title = "{$agent->getAgentsLastName()}";
?>

<h3><?= e($agent->getAgentsLastName()) ?></h3>
<p><?= $agent->getAgentsFirstName() ?></p>
<p class="text-muted">Né le <?= $agent->getAgentsBod()->format('d F Y') ?></p>
<p>Nationalité :
    <?php foreach ($agent->getCountries() as $country): ?>
        <?= e($country->getNationalitiesName()) ?></p>
<?php endforeach; ?>
<p>Spécialités : <br>
<?php foreach ($agent->getSpecialities() as $speciality): ?>
    <?= e($speciality->getSpecialitiesName()) ?>,
<?php endforeach; ?></p>