<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class Product extends Base
{

    public function getProducts(Request $request, Response $response, $args)
    {
        $products = $this->productResource->get();

        return $response->withJson($products);
    }

    public function getProductById(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];

        $products = $this->productResource->get($id);

        return $response->withJson($products);
    }

    public function createProduct(Request $request, Response $response, $args)
    {
        $username = $request->getAttribute('USERNAME');
        $user = $this->userResource->getByUsername($username);

        $data = $request->getParsedBody();

        $name=  filter_var($data['name'], FILTER_SANITIZE_STRING);

        $product = new \App\Model\Entity\Product($name, $user, new \DateTime("now"));

        $this->productResource->save($product);

        return $response->withJson($product);
    }
}
