<?php

namespace App\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="users")
 **/
class User extends Base
{
    /**
    * @Id @GeneratedValue @Column(type="integer")
    * @var int
    **/
    protected $id;

    /**
    * @Id @Column(type="string")
    * @var string
    **/
    protected $username;

    /**
    * @Column(type="string")
    * @var string
    **/
    protected $password;

    /**
    * @OneToMany(targetEntity="Item", mappedBy="user")
    * @var \Item[]
    **/
    protected $itemsList;

    /**
    *
    **/
    public function __construct()
    {
        $this->$itemsList = new ArrayCollection();
    }

}
