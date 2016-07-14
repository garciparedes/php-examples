<?php

class TicketEntity implements JsonSerializable {

    const ID = 'id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const COMPONENT = 'component';

    protected $id;
    protected $title;
    protected $description;
    protected $component;


    /**
     * Accept an array of data matching properties of this class
     * and create the class
     *
     * @param array $data The data to use to create
     */
     public function __construct(array $data){
         if (isset($data[self::ID])) {
             $this->id = $data[self::ID];
         }

         $this->title = $data[self::TITLE];
         $this->description = $data[self::DESCRIPTION];
         $this->component = $data[self::COMPONENT];
     }

     public function jsonSerialize()
        {
            return [
                self::ID => $this->getId(),
                self::TITLE => $this->getTitle(),
                self::DESCRIPTION => $this->getDescription(),
                self::COMPONENT => $this->getComponent()
            ];
        }



     public function getId()
     {
         return $this->id;
     }


     public function getTitle()
     {
         return $this->title;
     }


     public function getDescription()
     {
         return $this->description;
     }


     public function getShortDescription()
     {
         return substr($this->description, 0, 20);
     }


     public function getComponent()
     {
         return $this->component;
     }
}
