<?php

class UserMapper extends Mapper
{

    
    public function getUsers()
    {
        $sql = "SELECT id, username, password
            from users";
        $stmt = $this->db->query($sql);
        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = new UserEntity($row);
        }
        return $results;
    }


    public function getUserById($id)
    {
        $sql = "SELECT id, username, password
            from users where id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["user_id" => $id]);
        return new UserEntity($stmt->fetch());
    }
}
