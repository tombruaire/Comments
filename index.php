<?php
require('vendor/autoload.php');

$app = new Slim\Slim();
session_start();

$pdo = new PDO('mysql:dbname=comments;host=localhost', 'root', '', [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
$app->pdo = $pdo;


$app->get('/', function() use ($app){ require('views/index.php');  })->name('home');
$app->post('/', function() use ($app){ require('views/add.php'); });
$app->get('/delete/:id', function($id) use ($app){ require('views/delete.php'); })->name('comments.delete');

$app->run();