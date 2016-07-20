<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class Product extends Base
{

    public function getProducts(Request $request, Response $response, $args)
    {
        $con = $this->container->get('database');


        $productRepository = $con->getRepository('App\Model\Entity\Product');
        $products = $productRepository->findAll();
        $response = $response->withJson($products);
        return $response;
    }
}
