<?php
namespace App\Model\Entity;

use JsonSerializable;

/**
* @Entity @Table(name="items")
*/
class Item implements JsonSerializable
{

    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var int
    */
    protected $id;

    /**
    * @ManyToOne(targetEntity="App\Model\Entity\Product")
    * @var App\Model\Entity\Product
    */
    protected $product;

    /**
    * @Column(type="boolean")
    * @var boolean
    */
    protected $done;

    /**
    * @ManyToOne(targetEntity="App\Model\Entity\User", inversedBy="itemsList")
    * @var App\Model\Entity\User
    */
    protected $user;

    /**
    * @Column(type="datetime")
    * @var \DateTime
    */
    protected $createdAt;


    public function __construct($id, $product, $done, $user, $createdAt)
    {
        $this->id = $id;
        $this->product = $product;
        $this->done = $done;
        $this->user = $user;
        $this->createdAt = $createdAt;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setProduct($product)
    {
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setDone($done)
    {
        $this->done = $done;
    }

    public function getDone()
    {
        return $this->done;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setCreatedAt($CreatedAt)
    {
        $this->CreatedAt = $CreatedAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function jsonSerialize()
    {
        return [
            'id'    => $this->getId(),
            'product'  => $this->getProduct(),
            'done'  => $this->getDone(),
            'user'  => $this->getUser(),
            'createdAt'  => $this->getCreatedAt(),
        ];
    }
}
