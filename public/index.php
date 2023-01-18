<?php


use Database\DBConnection;

require_once __DIR__ . '/../vendor/autoload.php';


$db = new DBConnection('secret_agency');
$datas = $db->query('SELECT * FROM admin');

var_dump($datas);




