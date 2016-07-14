<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
spl_autoload_register(function ($classname) {
    require ("../classes/" . $classname . ".php");
});


# Settings
################################################################################
################################################################################

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost";
$config['db']['user']   = "user";
$config['db']['pass']   = "pass";
$config['db']['dbname'] = "exampleapp";


$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();


$container['logger'] = function($c)
{
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c)
{
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
    $response->getBody()->write("Hello, $name");

    return $response;
});



#Tickets
################################################################################

$app->get('/tickets', function (Request $request, Response $response)
{
    $this->logger->addInfo("Ticket list");
    $mapper = new TicketMapper($this->db);
    $tickets = $mapper->getTickets();

    $response = $response->withJson($tickets);
    return $response;
});


$app->get('/tickets/{id}', function(Request $request, Response $response, $args)
{
    $ticket_id = (int) $args['id'];
    $mapper = new TicketMapper($this->db);
    $ticket = $mapper->getTicketById($ticket_id);

    $response = $response->withJson($ticket);
    return $response;
});


$app->post('/tickets', function(Request $request, Response $response)
{
    $data = $request->getParsedBody();

    $ticket_data = [];
    $ticket_data['title'] = filter_var($data['title'], FILTER_SANITIZE_STRING);
    $ticket_data['description'] = filter_var($data['description'], FILTER_SANITIZE_STRING);

    $component_id = (int) $data['component'];
    $component_mapper = new ComponentMapper($this->db);
    $component = $component_mapper->getComponentById($component_id);
    $ticket_data['component'] = $component->getName();

    $ticket = new TicketEntity($ticket_data);
    $ticket_mapper = new TicketMapper($this->db);
    $ticket_mapper->save($ticket);

    $response = $response->withRedirect("/tickets");
    return $response;
});

# Run
################################################################################
################################################################################

$app->run();
