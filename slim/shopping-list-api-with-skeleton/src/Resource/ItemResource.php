<?php

namespace App\Resource;

use Doctrine\ORM\EntityManager;
use App\Model\Entity\Item;

class ItemResource extends Base
{

    private $itemRepository;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);

        $this->itemRepository = $this->entityManager->getRepository('\App\Model\Entity\Item');

    }

    public function get(\App\Model\Entity\User $user,int $id = null)
    {
        if ($id === null){
            return $this->itemRepository->findBy(array('user' => $user));
        } else {
            return $this->itemRepository->findOneBy(array('user' => $user, 'id' =>$id));
        }
    }

    public function save(Item $item)
    {
        $this->entityManager->persist($item);
        $this->entityManager->flush($item);
        return $item;
    }

    private function remove(Item $item)
    {
        $this->entityManager->remove($item);
        $this->entityManager->flush($item);
    }

    public function removeById(\App\Model\Entity\User $user,int $id)
    {
        $this->remove($this->get($user,$id));
    }
}
