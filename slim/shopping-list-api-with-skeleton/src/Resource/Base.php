<?php
namespace App\Resource;

use Doctrine\ORM\EntityManager;

abstract class Base
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
