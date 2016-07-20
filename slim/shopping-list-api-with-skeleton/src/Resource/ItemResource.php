<?php

namespace App\Resource;

use Doctrine\ORM\EntityManager;
use App\Model\Entity\Item;

class ItemResource extends Base
{

    protected $itemRepository;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);

        $this->itemRepository = $this->entityManager->getRepository('\App\Model\Entity\Item');

    }

    public function get(int $id = null)
    {
        if ($id === null){
            return $this->itemRepository->findAll();
        } else {
            return $this->itemRepository->find($id);
        }
    }

    public function save(Item $item)
    {
        $this->entityManager->persist($item);
        $this->entityManager->flush($item);
        return $item;
    }

    public function remove(Item $item)
    {
        $this->entityManager->remove($item);
        $this->entityManager->flush($item);
    }

    public function removeById(int $id)
    {
        $this->remove($this->get($id));
    }
}
