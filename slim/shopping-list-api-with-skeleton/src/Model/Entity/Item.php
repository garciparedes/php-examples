<?php
namespace App\Model\Entity;

/**
* @Entity @Table(name="items")
*/
class Item extends Base
{

    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var int
    */
    protected $id;

    /**
    * @ManyToOne(targetEntity="Product")
    * @var \Product
    */
    protected $product;

    /**
    * @Column(type="boolean")
    * @var boolean
    */
    protected $done;

    /**
    * @ManyToOne(targetEntity="User", inversedBy="itemsList")
    * @var \User
    */
    protected $user;

    /**
    * @Column(type="datetime")
    * @var \DateTime
    */
    protected $createdAt;
}
