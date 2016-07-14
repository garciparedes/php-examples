<?php

class ComponentEntity {

    protected $id;
    protected $name;


    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['component'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}
