<?php

namespace App\Controllers;

use Router\Router;

require_once __DIR__ . '/../vendor/autoload.php';

define('VIEWS', dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'.DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']).DIRECTORY_SEPARATOR);


//$db = new DBConnection('secret_agency');


// generate faker administrator

//if ($db->query('SELECT * FROM admin') == null) {
//
//    $faker = Faker\Factory::create('fr_FR');
//    for ($i = 0; $i < 10; $i++) {
//        $q = $db->getPDO()->prepare('INSERT INTO admin SET admin_lastname=?, admin_firstname=?,admin_email=?,admin_password=?,admin_created=?');
//        $q->execute([$faker->lastName, $faker->firstName, $faker->email, $faker->password, $faker->dateTime]);
//        $q->fetch();
//    }
//}
$router = new Router($_GET['url']);
$router->get('/', 'App\Controllers\HomeController@index');
$router->get('/posts/:id', 'App\Controllers\HomeController@show');

$router->run();
