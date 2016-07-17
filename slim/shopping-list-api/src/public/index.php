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


# Items
################################################################################

$app->get('/items', function (Request $request, Response $response)
{
    $this->logger->addInfo("Item list");
    $mapper = new ItemMapper($this->db);
    $items = $mapper->getItems();

    $response = $response->withJson($items);
    return $response;
});


$app->get('/items/{id}', function(Request $request, Response $response, $args)
{
    $item_id = (int) $args['id'];
    $mapper = new ItemMapper($this->db);
    $item = $mapper->getItemById($item_id);

    $response = $response->withJson($item);
    return $response;
});


$app->delete('/items/{id}', function(Request $request, Response $response, $args)
{
    $item_id = (int) $args['id'];
    $mapper = new ItemMapper($this->db);
    $item = $mapper->deleteItemById($item_id);

    #$response = $response->withRedirect("/items");
    return $response;
});


$app->put('/items', function(Request $request, Response $response)
{
    $data = $request->getParsedBody();

    $item_data = [];
    $item_data[ItemEntity::ID] = filter_var($data[ItemEntity::ID], FILTER_SANITIZE_STRING);
    $item_data[ItemEntity::NAME] = filter_var($data[ItemEntity::NAME], FILTER_SANITIZE_STRING);
    $item_data[ItemEntity::DONE] = filter_var($data[ItemEntity::DONE], FILTER_SANITIZE_STRING);


    // work out the component
    $user_id = (int)$data[UserEntity::USERNAME];

    $user_mapper = new UserMapper($this->db);
    $user = $user_mapper->getUserById($user_id);

    $item_data[ItemEntity::USER] = $user->getUsername();

    $item = new ItemEntity($item_data);

    $item_mapper = new ItemMapper($this->db);
    $item_mapper->update($item);

    #$response = $response->withRedirect("/items/" . $item_data[ItemEntity::ID]);
    return $response;
});


$app->post('/items', function (Request $request, Response $response)
{
    $data = $request->getParsedBody();

    $item_data = [];
    $item_data[ItemEntity::NAME] = filter_var($data[ItemEntity::NAME], FILTER_SANITIZE_STRING);
    $item_data[ItemEntity::DONE] = filter_var($data[ItemEntity::DONE], FILTER_SANITIZE_STRING);


    // work out the component
    $user_id = (int)$data[UserEntity::USERNAME];

    $user_mapper = new UserMapper($this->db);
    $user = $user_mapper->getUserById($user_id);

    $item_data[ItemEntity::USER] = $user->getUsername();

    $item = new ItemEntity($item_data);

    $item_mapper = new ItemMapper($this->db);
    $item_mapper->save($item);

    $response = $response->withRedirect("/items");
    return $response;
});


# Run
################################################################################
################################################################################

$app->run();
