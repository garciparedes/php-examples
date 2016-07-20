<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Interop\Container\ContainerInterface;

class Item extends Base
{

    protected $itemRepository;

    protected $productRepository;

    protected $userRepository;

    /**
     * Controller Contructor.
     *
     * @param \Interop\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->itemRepository = $this->database->getRepository('App\Model\Entity\Item');
        $this->productRepository = $this->database->getRepository('App\Model\Entity\Product');
        $this->userRepository = $this->database->getRepository('App\Model\Entity\User');
    }


    public function getItems(Request $request, Response $response, $args)
    {
        $items = $this->itemRepository->findAll();
        $response = $response->withJson($items);
        return $response;
    }

    public function getItemById(Request $request, Response $response, $args)
    {

        $id = (int) $args['id'];

        $item = $this->itemRepository->find($id);
        $response = $response->withJson($item);
        return $response;
    }

    public function createItem(Request $request, Response $response, $args)
    {

        $data = $request->getParsedBody();

        $productId =  filter_var($data['productId'], FILTER_SANITIZE_NUMBER_INT);
        $product = $this->productRepository->find($productId);

        $user = $this->userRepository->find(1);

        $item = new \App\Model\Entity\Item(null, $product, 0, $user, new \DateTime("now"));

        $this->database->persist($item);
        $this->database->flush($item);
        $response = $response->withJson($item);
        return $response;
    }

    public function updateItem(Request $request, Response $response, $args)
    {

        $id = (int) $args['id'];
        $item = $this->itemRepository->find($id);


        $data = $request->getParsedBody();

        if(array_key_exists('productId', $data)) {
            $productId =  filter_var($data['productId'], FILTER_SANITIZE_NUMBER_INT);

            $product = $this->productRepository->find($productId);
            $item->setProduct($product);
        }

        if(array_key_exists('done', $data)){
            $item->setDone(filter_var( $data['done'], FILTER_VALIDATE_BOOLEAN));
        }

        $this->database->persist($item);
        $this->database->flush($item);
        $response = $response->withJson($item);
        return $response;
    }

    public function removeItem(Request $request, Response $response, $args)
    {

        $id = (int) $args['id'];
        $item = $this->itemRepository->find($id);

        $this->database->remove($item);
        $this->database->flush($item);

        return $response;
    }
}
