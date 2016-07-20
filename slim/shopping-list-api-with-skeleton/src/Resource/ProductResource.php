<?php

namespace App\Resource;

use Doctrine\ORM\EntityManager;
use App\Model\Entity\Product;

class ProductResource extends Base
{

    protected $productRepository;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);

        $this->productRepository = $this->entityManager->getRepository('\App\Model\Entity\Product');

    }

    public function get(int $id = null)
    {
        if ($id === null){
            return $this->productRepository->findAll();
        } else {
            return $this->productRepository->find($id);
        }
    }

    public function save(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush($product);
        return $product;
    }

    public function remove(Product $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush($product);
    }

    public function removeById(int $id)
    {
        $this->remove($this->get($id));
    }
}
