<?php

use App\Models\Mappers\ContactMapper;
$container = $app->getContainer();

$container['pdo'] = function($c) {
    $config = $c->get('settings')['db'];
    $dns = sprintf("mysql:host=%s;dbname=%s", $config['host'], $config['dbname']);
    $pdo =  new \PDO($dns, $config['user'], $config['password']);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return $pdo;
};

//Mappers
$container[ContactMapper::class] = function($c) {
   return new ContactMapper($c->get('pdo'));
};