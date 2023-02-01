<?php

$id = (int)$params['id'];

use App\Model\Nationalities;
use Database\DBConnection;


$db = new DBConnection();
$query = $db->getPDO()->prepare('SELECT * FROM nationalities WHERE nationalities_id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Nationalities::class);
$nationality = $query->fetch();

if ($nationality === false) {
    throw new Exception("Aucun pays ne correspond à cet ID");
}

$title = "{$nationality->getNationalitiesName()}";

?>

<h1><?= e($title) ?></h1>
