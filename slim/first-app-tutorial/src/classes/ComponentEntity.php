<?php

class ComponentEntity {

    const ID = 'id';
    const COMPONENT = 'component';

    protected $id;
    protected $name;


    public function __construct(array $data)
    {
        $this->id = $data[self::ID];
        $this->name = $data[self::COMPONENT];
    }

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
               self::ID => $this->getId(),
               self::COMPONENT => $this->getName()
           ];
       }

}
