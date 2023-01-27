<?php

use App\Router;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require_once __DIR__ . '/../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();


$router = new Router(dirname(__DIR__) . '/views');
$router
    ->get('/', 'dashboard/index', 'home')
    ->get('/agents', 'agents/index', 'agents')
    ->get('/agents/[i:id]', 'agents/show', 'show')
    ->run();

