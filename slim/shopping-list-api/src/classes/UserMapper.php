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

    public function getUserPasswordMap()
    {
        $sql = "SELECT id, username, password
            from users";
        $stmt = $this->db->query($sql);
        $results = [];
        while($row = $stmt->fetch()) {
            $results[$row[UserEntity::USERNAME]] = $row[UserEntity::PASSWORD];
        }
        return $results;
    }


    public function getIdByUsername($username)
    {
        $sql = "SELECT id, username, password
            from users where username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["username" => $username]);
        return $stmt->fetch()[UserEntity::ID];
    }


    public function getUserById($id)
    {
        $sql = "SELECT id, username, password
            from users where id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["user_id" => $id]);
        return new UserEntity($stmt->fetch());
    }

    public function save(UserEntity $user)
    {
        $sql = "INSERT INTO users
            (username, password) VALUES
            (:username, :password)";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            "username" => $user->getUsername(),
            "password" => $user->getPassword(),
        ]);

        if(!$result) {
            throw new Exception("could not save record");
        }
    }
}
