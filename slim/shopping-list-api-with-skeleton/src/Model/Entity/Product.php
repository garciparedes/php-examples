<?php
namespace App\Model\Entity;

/**
* @Entity @Table(name="products")
*/
class Product extends Base
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
}
