<?php
$id = (int)$params['id'];

use App\Model\Contacts;
use App\Model\Nationalities;
use App\Model\Targets;
use Database\DBConnection;


$db = new DBConnection();
$query = $db->getPDO()->prepare('SELECT * FROM contacts WHERE contacts_id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Contacts::class);
$contact = $query->fetch();

if ($contact === false) {
    throw new Exception("Aucun contact ne correspond à cet ID");
}

$query = $db->getPDO()->prepare("SELECT n.nationalities_name
FROM nationalities n 
JOIN contacts c on n.nationalities_id = c.nationalities_nationalities_id
WHERE c.contacts_id = :id");
$query->execute(['id' => $contact->getContactsId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Nationalities::class);
$nationalities = $query->fetchAll();

$title = "Cibles {$contact->getContactsLastName()}";
?>
    <h3>Contact <?= e($contact->getContactsLastName()) ?></h3>
    <p><?= $contact->getContactsFirstName() ?></p>
    <p class="text-muted">Né le <?= $contact->getContactsBod()->format('d F Y') ?></p>
<?php foreach ($nationalities as $nationality): ?>
    <p>Pays : <?= e($nationality->getNationalitiesName()) ?></p>
<?php endforeach; ?>