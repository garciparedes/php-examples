<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class Item extends Base
{

    public function getItems(Request $request, Response $response, $args)
    {
        $items = $this->itemResource->get();
        return $response->withJson($items);
    }

    public function getItemById(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $item = $this->itemResource->get($id);
        return $response->withJson($item);
    }

    public function createItem(Request $request, Response $response, $args)
    {

        $data = $request->getParsedBody();

        $productId =  filter_var($data['productId'], FILTER_SANITIZE_NUMBER_INT);
        $product = $this->productResource->get($productId);

        $user = $this->userResource->get(1);

        $item = new \App\Model\Entity\Item(null, $product, false, $user, new \DateTime("now"));

        $this->itemResource->save($item);

        return $response->withJson($item);
    }

    public function updateItemProperties(Request $request, Response $response, $args)
    {

        $id = (int) $args['id'];
        $item = $this->itemResource->get($id);

        $data = $request->getParsedBody();


        if(array_key_exists('productId', $data)) {
            $productId =  filter_var($data['productId'], FILTER_SANITIZE_NUMBER_INT);
            $product = $this->productResource->get($productId);
            $item->setProduct($product);
        }

        if(array_key_exists('done', $data)){
            $item->setDone(filter_var( $data['done'], FILTER_VALIDATE_BOOLEAN));
        }

        $item = $this->itemResource->save($item);

        return $response->withJson($item);
    }

    public function removeItem(Request $request, Response $response, $args)
    {

        $id = (int) $args['id'];

        $this->itemResource->removeById($id);
        return $response;
    }
}
