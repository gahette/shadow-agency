<?php

use App\Router;

require_once __DIR__ . '/../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


$router = new Router(dirname(__DIR__) . '/views');
$router
    ->get('/dashboard', 'dashboard/index', 'dashboard')
    ->get('/agents', 'agents/show', 'show')
    ->run();

