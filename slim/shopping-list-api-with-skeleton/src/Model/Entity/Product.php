<?php
namespace App\Model\Entity;

use JsonSerializable;

/**
* @Entity @Table(name="products")
*/
class Product extends Base implements JsonSerializable
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


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        return [
            'id'    => $this->getId(),
            'name'  => $this->getName(),
        ];
    }
}
