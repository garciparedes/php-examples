<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class Item extends Base
{

    public function getItems(Request $request, Response $response, $args)
    {
        $con = $this->container->get('database');
        $stmt = $con->query('SELECT * FROM items');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, \App\Model\Entity\Item::class);
        $rows = $stmt->fetchAll();

        $response = $response->withJson($rows);
        return $response;
    }
}
