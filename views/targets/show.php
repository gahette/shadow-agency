<?php
$id = (int)$params['id'];

use App\Model\Nationalities;
use App\Model\Targets;
use Database\DBConnection;


$db = new DBConnection();
$query = $db->getPDO()->prepare('SELECT * FROM targets WHERE targets_id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Targets::class);
$target = $query->fetch();

if ($target === false) {
    throw new Exception("Aucune cible ne correspond à cet ID");
}

$query = $db->getPDO()->prepare("SELECT n.nationalities_name
FROM nationalities n 
JOIN targets t on t.nationalities_nationalities_id = n.nationalities_id
WHERE t.targets_id = :id");
$query->execute(['id' => $target->getTargetsId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Nationalities::class);
$nationalities = $query->fetchAll();

$title = "Cibles {$target->getTargetsLastName()}";
?>
    <h3>Cible <?= e($target->getTargetsLastName()) ?></h3>
    <p><?= $target->getTargetsFirstName() ?></p>
    <p class="text-muted">Né le <?= $target->getTargetsBod()->format('d F Y') ?></p>
<?php foreach ($nationalities as $nationality): ?>
    <p>Pays : <?= e($nationality->getNationalitiesName()) ?></p>
<?php endforeach; ?>