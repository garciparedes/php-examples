<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class Item extends Base
{

    public function getItems(Request $request, Response $response, $args)
    {
        $con = $this->container->get('database');


        $itemRepository = $con->getRepository('App\Model\Entity\Item');
        $items = $itemRepository->findAll();
        $response = $response->withJson($items);
        return $response;
    }
}
