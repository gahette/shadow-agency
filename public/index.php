<?php


use Database\DBConnection;

require_once __DIR__ . '/../vendor/autoload.php';


$db = new DBConnection('secret_agency');



// generate faker administrator

if ($db->query('SELECT * FROM admin') == null) {

    $faker = Faker\Factory::create('fr_FR');
    for ($i = 0; $i < 10; $i++) {
        $q = $db->getPDO()->prepare('INSERT INTO admin SET admin_lastname=?, admin_firstname=?,admin_email=?,admin_password=?,admin_created=?');
        $q->execute([$faker->lastName, $faker->firstName, $faker->email, $faker->password, $faker->date]);
        $q->fetch();
    }
}
