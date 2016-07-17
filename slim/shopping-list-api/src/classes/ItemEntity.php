<?php

class ItemEntity {

    const ID    = 'id';
    const NAME  = 'name';
    const DONE  = 'done';
    const USER  = 'user';

    private $id;
    private $name;
    private $done;
    private $user;

    public function __construct(array $data)
    {
        $this->id   = $data[self::ID];
        $this->name = $data[self::NAME];
        $this->done = $data[self::DONE];
        $this->user = $data[self::USER];
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

    public function()
    {
        return $this->user;
    }

    public function jsonSerialize()
    {
        return [
            self::ID    => $this->getID();
            self::NAME  => $this->getName();
            self::DONE  => $this->getDone();
        ];
    }
}
