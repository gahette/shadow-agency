<?php

use App\Router;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;


//chargement du fichier autoload de composer
require_once __DIR__ . '/../vendor/autoload.php';

define('DEBUG_TIME', microtime(true)); //constante temps actuelle

// debugger whoops a commenter pour la mise en production
$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();


//suppression numéro de page 1 dans url
if (isset($_GET['page']) && $_GET['page'] === '1') {
//Réécrire l'url sans le paramètre ?page
    //Séparation des paramètres de l'url
    //Récupération partie de gauche
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    //Construction partie de droite
    $get = $_GET; //Variable intermédiaire pour ne pas modifier les variables globals
    unset($get['page']);
    $query = http_build_query($get);
    if (!empty($query)) {
        $uri = $uri . '?' . $query;
    }
    header('Location: ' . $uri);
    http_response_code(301);
    exit();
}


//démarrage du router
$router = new Router(dirname(__DIR__) . '/views');


//Gestion des url
$router
    ->get('/', 'dashboard/index', 'home')
    ->get('/agents', 'agents/index', 'agents')
    ->get('/agents/[i:id]', 'agents/show', 'show')
    ->match('/agents/edit/[i:id]', 'agents/edit', 'agents_edit')
    ->post('/agents/[i:id]/delete', 'agents/delete', 'agents_delete')
    ->get('/targets', 'targets/index', 'targets')
    ->get('/targets/[i:id]', 'targets/show', 'target')
    ->get('/contacts', 'contacts/index', 'contacts')
    ->get('/contacts/[i:id]', 'contacts/show', 'contact')
    ->get('/hideouts', 'hideouts/index', 'hideouts')
    ->get('/hideouts/[i:id]', 'hideouts/show', 'hideout')
    ->get('/countries', 'countries/index', 'countries')
    ->get('/countries/[i:id]', 'countries/show', 'country')
    ->get('/specialities', 'specialities/index', 'specialities')
    ->get('/typeshideouts', 'typeshideouts/index', 'typeshideouts')
    ->run();

