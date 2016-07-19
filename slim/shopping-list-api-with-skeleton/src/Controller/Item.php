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

    public function getItemById(Request $request, Response $response, $args)
    {
        $con = $this->container->get('database');

        $id = (int) $args['id'];

        $itemRepository = $con->getRepository('App\Model\Entity\Item');
        $item = $itemRepository->find($id);
        $response = $response->withJson($item);
        return $response;
    }

    public function createItem(Request $request, Response $response, $args)
    {
        $con = $this->container->get('database');

        $data = $request->getParsedBody();

        $productId =  filter_var($data['productId'], FILTER_SANITIZE_NUMBER_INT);
        $productRepository = $con->getRepository('App\Model\Entity\Product');
        $product = $productRepository->find($productId);

        $userRepository = $con->getRepository('App\Model\Entity\User');
        $user = $userRepository->find(1);

        $item = new \App\Model\Entity\Item(null, $product, 0, $user, new \DateTime("now"));

        $con->persist($item);
        $con->flush($item);
        $response = $response->withJson($item);
        return $response;
    }

    public function updateItem(Request $request, Response $response, $args)
    {
        $con = $this->container->get('database');

        $id = (int) $args['id'];
        $itemRepository = $con->getRepository('App\Model\Entity\Item');
        $item = $itemRepository->find($id);


        $data = $request->getParsedBody();

        if(array_key_exists('productId', $data)) {
            $productId =  filter_var($data['productId'], FILTER_SANITIZE_NUMBER_INT);

            $productRepository = $con->getRepository('App\Model\Entity\Product');
            $product = $productRepository->find($productId);
            $item->setProduct($product);
        }

        if(array_key_exists('done', $data)){
            $item->setDone(filter_var( $data['done'], FILTER_VALIDATE_BOOLEAN));
        }



        $con->persist($item);
        $con->flush($item);
        $response = $response->withJson($item);
        return $response;
    }

    public function removeItem(Request $request, Response $response, $args)
    {
        $con = $this->container->get('database');

        $id = (int) $args['id'];
        $itemRepository = $con->getRepository('App\Model\Entity\Item');
        $item = $itemRepository->find($id);

        $con->remove($item);
        $con->flush($item);
        
        return $response;
    }
}
