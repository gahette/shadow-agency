<?php

use App\Auth;
use App\Table\AgentsTable;
use Database\DBConnection;

Auth::check();

$title = 'Agents';

$pdo = new DBConnection();
$table = new AgentsTable($pdo->getPDO());
$table->delete($params['id']);
header('Location: ' . $router->url('agents') . '?delete =1');


