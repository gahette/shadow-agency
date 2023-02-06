<?php

use Database\DBConnection;

require_once __DIR__ . '/../vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$db = new DBConnection();

$db->getPDO()->exec('SET FOREIGN_KEY_CHECKS = 0');

//$db->getPDO()->exec('TRUNCATE TABLE admin');
$db->getPDO()->exec('TRUNCATE TABLE agents');
$db->getPDO()->exec('TRUNCATE TABLE contacts');
$db->getPDO()->exec('TRUNCATE TABLE hideouts');
//$db->getPDO()->exec('TRUNCATE TABLE missions');
$db->getPDO()->exec('TRUNCATE TABLE specialities');
//$db->getPDO()->exec('TRUNCATE TABLE status');
$db->getPDO()->exec('TRUNCATE TABLE targets');
$db->getPDO()->exec('TRUNCATE TABLE types_hideouts');
//$db->getPDO()->exec('TRUNCATE TABLE typesmissions');
$db->getPDO()->exec('SET FOREIGN_KEY_CHECKS = 1');

$agents = [];
$specialities = [];

for ($i = 0; $i < 50; $i++) {
    $db->getPDO()->exec("INSERT INTO agents SET agents_lastname='$faker->lastName', agents_firstname='$faker->firstName',agents_bod='$faker->date',nationalities_nationalities_id= '$faker->randomDigitNotNull'");
    $agents[] = $db->getPDO()->lastInsertId();
}

for ($i = 0; $i < 10; $i++) {
    $db->getPDO()->exec("INSERT INTO specialities SET specialities_name='$faker->word'");
    $specialities[] = $db->getPDO()->lastInsertId();
}
foreach ($agents as $agent) {
    $randomSpecialities = $faker->randomElements($specialities, rand(0, count($specialities)));
    foreach ($randomSpecialities as $speciality) {
        $db->getPDO()->exec("INSERT INTO agents_specialities SET agents_agents_id=$agent, specialities_specialities_id=$speciality");
    }
}


for ($i = 0; $i < 50; $i++) {
    $db->getPDO()->exec("INSERT INTO targets SET targets_lastname='$faker->lastName', targets_firstname='$faker->firstName',targets_bod='$faker->date',targets_nickname='$faker->userName',nationalities_nationalities_id= '$faker->randomDigitNotNull'");
}
for ($i = 0; $i < 50; $i++) {
    $db->getPDO()->exec("INSERT INTO contacts SET contacts_lastname='$faker->lastName', contacts_firstname='$faker->firstName',contacts_bod='$faker->date',contacts_nickname='$faker->userName',nationalities_nationalities_id= '$faker->randomDigitNotNull'");
}
for ($i = 0; $i < 10; $i++) {
    $db->getPDO()->exec("INSERT INTO types_hideouts SET types_hideouts_name='$faker->word'");
}

for ($i = 0; $i < 100; $i++) {
    $db->getPDO()->exec("INSERT INTO hideouts SET hideouts_address='$faker->address', nationalities_nationalities_id= '$faker->randomDigitNotNull', types_hideouts_types_hideouts_id= '$faker->randomDigitNotNull'");
}

//$password = password_hash('admin', PASSWORD_BCRYPT);
//$db->getPDO()->exec("INSERT INTO admin SET admin_lastname='Doe', admin_firstname='John', admin_email='john@doe.com', admin_password='$password', admin_created='$faker->date'");

