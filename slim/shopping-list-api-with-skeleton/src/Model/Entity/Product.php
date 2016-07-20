<?php
namespace App\Model\Entity;

use JsonSerializable;

/**
* @Entity @Table(name="products")
*/
class Product implements JsonSerializable
{

    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var int
    */
    protected $id;

    /**
    * @Column(type="string")
    * @var string
    */
    protected $name;

    /**
    * @ManyToOne(targetEntity="App\Model\Entity\User", inversedBy="createdProducts")
    * @var App\Model\Entity\User
    */
    protected $creator;

    /**
    * @Column(type="datetime")
    * @var \DateTime
    */
    protected $createdAt;

    public function __construct($name, $creator, $createdAt)
    {
        $this->name = $name;
        $this->creator = $creator;
        $this->createdAt = $createdAt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCreator()
    {
        return $this->creator;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function jsonSerialize()
    {
        return [
            'id'    => $this->getId(),
            'name'  => $this->getName(),
            'creator' => $this->getCreator()->getUsername(),
            'createdAt'  => $this->getCreatedAt(),
        ];
    }
}
