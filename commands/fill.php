<?php

use Database\DBConnection;

require_once __DIR__ . '/../vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$db = new DBConnection();

$db->getPDO()->exec('SET FOREIGN_KEY_CHECKS = 0');

//$db->getPDO()->exec('TRUNCATE TABLE admin');
$db->getPDO()->exec('TRUNCATE TABLE agents');
$db->getPDO()->exec('TRUNCATE TABLE contacts');
$db->getPDO()->exec('TRUNCATE TABLE targets');
$db->getPDO()->exec('TRUNCATE TABLE hideouts');
$db->getPDO()->exec('TRUNCATE TABLE status');
$db->getPDO()->exec('TRUNCATE TABLE specialities');
$db->getPDO()->exec('TRUNCATE TABLE types_hideouts');
$db->getPDO()->exec('TRUNCATE TABLE types_missions');
$db->getPDO()->exec('TRUNCATE TABLE missions');
$db->getPDO()->exec('SET FOREIGN_KEY_CHECKS = 1');

$agents = [];
$contacts = [];
$targets = [];
$specialities = [];
$missions = [];

for ($i = 0; $i < 50; $i++) {
    $db->getPDO()->exec("INSERT INTO agents SET agents_lastname='$faker->lastName', agents_firstname='$faker->firstName',agents_bod='$faker->date',nationalities_nationalities_id= '$faker->randomDigitNotNull'");
    $agents[] = $db->getPDO()->lastInsertId();
}
for ($i = 0; $i < 10; $i++) {
    $db->getPDO()->exec("INSERT INTO status SET status_name='$faker->word'");
}
for ($i = 0; $i < 10; $i++) {
    $db->getPDO()->exec("INSERT INTO types_missions SET types_missions_name='$faker->word'");
}
for ($i = 0; $i < 20; $i++) {
    $db->getPDO()->exec("INSERT INTO missions SET missions_title='$faker->sentence', missions_description='$faker->text',missions_nickname='$faker->userName',missions_created='$faker->date',missions_closed= '$faker->date',nationalities_nationalities_id= '$faker->randomDigitNotNull',status_status_id='$faker->randomDigitNotNull', types_missions_types_missions_id='$faker->randomDigitNotNull' ");
    $missions[] = $db->getPDO()->lastInsertId();
}
foreach ($agents as $agent) {
    $randomSpecialities = $faker->randomElements($specialities, rand(0, count($specialities)));
    foreach ($randomSpecialities as $speciality) {
        $db->getPDO()->exec("INSERT INTO agents_specialities SET agents_agents_id=$agent, specialities_specialities_id=$speciality");
    }
}
foreach ($missions as $mission) {
    $randomMissions = $faker->randomElements($missions, rand(0, count($missions)));
    foreach ($randomMissions as $randomMission) {
        $db->getPDO()->exec("INSERT INTO missions_specialities SET missions_missions_id=$mission, specialities_specialities_id=$randomMission");
    }
}
foreach ($missions as $mission) {
    $randomAgents = $faker->randomElements($missions, rand(0, count($missions)));
    foreach ($randomAgents as $randomAgent) {
        $db->getPDO()->exec("INSERT INTO missions_agents SET missions_missions_id=$mission, agents_agents_id=$randomAgent");
    }
}
foreach ($missions as $mission) {
    $randomContacts = $faker->randomElements($missions, rand(0, count($missions)));
    foreach ($randomContacts as $randomContact) {
        $db->getPDO()->exec("INSERT INTO missions_contacts SET missions_missions_id=$mission, contacts_contacts_id=$randomContact");
    }
}
foreach ($missions as $mission) {
    $randomTargets = $faker->randomElements($missions, rand(0, count($missions)));
    foreach ($randomTargets as $randomTarget) {
        $db->getPDO()->exec("INSERT INTO missions_targets SET missions_missions_id=$mission, targets_targets_id=$randomTarget");
    }
}
for ($i = 0; $i < 10; $i++) {
    $db->getPDO()->exec("INSERT INTO specialities SET specialities_name='$faker->word'");
    $specialities[] = $db->getPDO()->lastInsertId();
}
for ($i = 0; $i < 50; $i++) {
    $db->getPDO()->exec("INSERT INTO targets SET targets_lastname='$faker->lastName', targets_firstname='$faker->firstName',targets_bod='$faker->date',targets_nickname='$faker->userName',nationalities_nationalities_id= '$faker->randomDigitNotNull'");
    $targets[] = $db->getPDO()->lastInsertId();
}
for ($i = 0; $i < 50; $i++) {
    $db->getPDO()->exec("INSERT INTO contacts SET contacts_lastname='$faker->lastName', contacts_firstname='$faker->firstName',contacts_bod='$faker->date',contacts_nickname='$faker->userName',nationalities_nationalities_id= '$faker->randomDigitNotNull'");
    $contacts[] = $db->getPDO()->lastInsertId();
}
for ($i = 0; $i < 10; $i++) {
    $db->getPDO()->exec("INSERT INTO types_hideouts SET types_hideouts_name='$faker->word'");
}
for ($i = 0; $i < 100; $i++) {
    $db->getPDO()->exec("INSERT INTO hideouts SET hideouts_address='$faker->address', nationalities_nationalities_id= '$faker->randomDigitNotNull', types_hideouts_types_hideouts_id= '$faker->randomDigitNotNull',missions_missions_id= '$faker->randomDigitNotNull'");
}



$password = password_hash('admin', PASSWORD_BCRYPT);
$db->getPDO()->exec("INSERT INTO users SET users_lastname='Doe', users_firstname='John', users_email='john@doe.com', users_password='$password', users_created='$faker->date'");

