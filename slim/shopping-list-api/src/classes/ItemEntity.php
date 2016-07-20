<?php

class ItemEntity implements JsonSerializable {


    const ID    = 'id';
    const NAME  = 'name';
    const DONE  = 'done';
    const USER  = 'username';


    private $id;
    private $name;
    private $done;
    private $username;


    public function __construct(array $data)
    {
        $this->id   = $data[self::ID];
        $this->name = $data[self::NAME];
        $this->done = $data[self::DONE];
        $this->username = $data[self::USER];
    }


    public function getId()
    {
        return $this->id;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getDone()
    {
        return $this->done;
    }


    public function getUsername()
    {
        return $this->username;
    }


    public function jsonSerialize()
    {
        return [
            self::ID    => $this->getID(),
            self::NAME  => $this->getName(),
            self::DONE  => $this->getDone(),
            //self::USER  => $this->getUsername()
        ];
    }
}
