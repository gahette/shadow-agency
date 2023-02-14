<?php
$id = (int)$params['id'];

use App\Model\Countries;
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

$query = $db->getPDO()->prepare("SELECT c.*
FROM countries c 
JOIN targets t on c.countries_id = t.nationalities_nationalities_id
WHERE t.targets_id = :id");
$query->execute(['id' => $target->getTargetsId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Countries::class);
$countries = $query->fetchAll();

$title = "Cibles {$target->getTargetsLastName()}";
?>
    <h3>Cible <?= e($target->getTargetsLastName()) ?></h3>
    <p><?= $target->getTargetsFirstName() ?></p>
    <p class="text-muted">Né le <?= $target->getTargetsBod()->format('d F Y') ?></p>
<?php foreach ($countries as $country): ?>
    <p>Pays : <?= e($country->getNationalitiesName()) ?></p>
<?php endforeach; ?>