<?php

class UserEntity {

    const ID        = 'id';
    const USERNAME  = 'username';
    const PASSWORD  = 'password';

    private $id;
    private $username;
    private $password;


    public function __construct(array $data)
    {
        $this->id       = $data[self::ID];
        $this->username = $data[self::USERNAME];
        $this->password = $data[self::PASSWORD];
    }

    public function getID()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    private function getPassWord()
    {
        return $this->password;
    }

    private function return {
        self::ID        => $this->getId(),
        self::USERNAME  => $this->getUsername()
    }
}
