<?php
$id = (int)$params['id'];

use App\Model\Agents;
use App\Model\Nationalities;
use App\Model\Specialities;
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
FROM nationalities n 
JOIN agents a on a.nationalities_nationalities_id = n.nationalities_id
WHERE a.agents_id = :id");
$query->execute(['id' => $agent->getAgentsId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Nationalities::class);
$nationalities = $query->fetchAll();


$query = $db->getPDO()->prepare('SELECT s.specialities_name
FROM agents_specialities asp 
Join specialities s on s.specialities_id = asp.specialities_specialities_id
WHERE asp.agents_agents_id = :id');
$query->execute(['id'=>$agent->getAgentsId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Specialities::class);
$specialities = $query->fetchAll();

$title = "{$agent->getAgentsLastName()}";
?>

<h3>Agent <?= e($agent->getAgentsLastName()) ?></h3>
<p><?= $agent->getAgentsFirstName() ?></p>
<p class="text-muted">Né le <?= $agent->getAgentsBod()->format('d F Y') ?></p>
<?php foreach ($nationalities as $nationality): ?>
    <p>Pays : <?= e($nationality->getNationalitiesName()) ?></p>
<?php endforeach; ?>
<p>Spécialités :
<?php foreach ($specialities as $speciality): ?>
<?= e($speciality->getSpecialitiesName()) ?>, </p>
<?php endforeach; ?>