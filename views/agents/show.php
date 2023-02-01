<?php
$id = (int)$params['id'];

use App\Model\Agents;
use App\Model\Nationalities;
use Database\DBConnection;


$db = new DBConnection();
$query = $db->getPDO()->prepare('SELECT * FROM agents WHERE agents_id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Agents::class);
$agent = $query->fetch();

if ($agent === false) {
    throw new Exception("Aucun agent ne correspond à cet ID");
}

$query = $db->getPDO()->prepare("SELECT n.nationalities_name
FROM agents_has_nationalities an 
JOIN nationalities n on an.nationalities_nationalities_id = n.nationalities_id
WHERE an.agents_agents_id = :id");
$query->execute(['id' => $agent->getAgentsId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Nationalities::class);
$nationalities = $query->fetchAll();
?>

<h1><?= e($agent->getAgentsLastName()) ?></h1>
<p><?= $agent->getAgentsFirstName() ?></p>
<p class="text-muted">Né le <?= $agent->getAgentsBod()->format('d F Y') ?></p>
<?php foreach ($nationalities as $nationality): ?>
    <p><?= e($nationality->getNationalitiesName()) ?></p>
<?php endforeach; ?>



