<?php

namespace App\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use JsonSerializable;

/**
 * @Entity @Table(name="users")
 **/
class User implements JsonSerializable
{
    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var int
    **/
    protected $id;

    /**
    * @Column(type="string")
    * @var string
    **/
    protected $username;

    /**
    * @Column(type="string")
    * @var string
    **/
    protected $email;

    /**
    * @Column(type="string")
    * @var string
    **/
    protected $password;

    /**
    * @OneToMany(targetEntity="App\Model\Entity\Item", mappedBy="user")
    * @var App\Model\Entity\Item[]
    **/
    protected $itemsList;

    /**
    * @OneToMany(targetEntity="App\Model\Entity\Product", mappedBy="creator")
    * @var App\Model\Entity\Product[]
    **/
    protected $createdProducts;

    /**
    *
    **/
    public function __construct()
    {
        if ($this->itemsList === null){
            $this->itemsList = new ArrayCollection();
        }

        if ($this->createdProducts === null){
            $this->createdProducts = new ArrayCollection();
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getItemList()
    {
        return $this->itemsList;
    }

    public function getItemListArray()
    {
        return $this->getItemList()->toArray();
    }

    public function getCreatedProducts()
    {
        return $this->createdProducts;
    }

    public function getCreatedProductsArray()
    {
        return $this->getCreatedProducts()->toArray();
    }

    public function jsonSerialize()
    {
        return [
            'id'    => $this->getId(),
            'username'  => $this->getUsername(),
            'createdProducts' =>$this->getCreatedProductsArray(),
        ];
    }

}
