<?php

use Database\DBConnection;

require_once __DIR__ . '/../vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$db = new DBConnection();

$db->getPDO()->exec('SET FOREIGN_KEY_CHECKS = 0');

$db->getPDO()->exec('TRUNCATE TABLE admin');
$db->getPDO()->exec('TRUNCATE TABLE agents');
$db->getPDO()->exec('TRUNCATE TABLE contacts');
$db->getPDO()->exec('TRUNCATE TABLE hideouts');
$db->getPDO()->exec('TRUNCATE TABLE missions');
$db->getPDO()->exec('TRUNCATE TABLE specialities');
$db->getPDO()->exec('TRUNCATE TABLE status');
$db->getPDO()->exec('TRUNCATE TABLE targets');
$db->getPDO()->exec('TRUNCATE TABLE typeshideouts');
$db->getPDO()->exec('TRUNCATE TABLE typesmissions');
$db->getPDO()->exec('SET FOREIGN_KEY_CHECKS = 1');


for ($i = 0; $i < 50; $i++) {
    $db->getPDO()->exec("INSERT INTO agents SET agents_lastname='$faker->lastName', agents_firstname='$faker->firstName',agents_bod='$faker->date'");
}


$password = password_hash('admin', PASSWORD_BCRYPT);
$db->getPDO()->exec("INSERT INTO admin SET admin_lastname='Doe', admin_firstname='John', admin_email='john@doe.com', admin_password='$password', admin_created='$faker->date'");

