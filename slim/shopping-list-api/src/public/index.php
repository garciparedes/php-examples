<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';


spl_autoload_register(function ($classname)
{
    require ("../classes/" . $classname . ".php");
});

# Settings
################################################################################
################################################################################


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost";
$config['db']['user']   = "user";
$config['db']['pass']   = "password";
$config['db']['dbname'] = "shoppingListApi";


$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();


$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};


$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};


# Routes
################################################################################
################################################################################



# Hello
################################################################################

$app->get('/hello/{name}', function (Request $request, Response $response)
{
    $name = $request->getAttribute('name');
    $this->logger->addInfo("Something interesting happened: ". $name . " is here.");
    $response->getBody()->write("Hello, ". $name);

    return $response;
});


# Run
################################################################################
################################################################################

$app->run();
