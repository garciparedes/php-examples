<?php

class ItemMapper extends Mapper {


    public function getItems($username)
    {
        $sql = 'SELECT i.id, i.name, i.done, u.username
            from items i
            join users u on (u.id = i.user_id)
            where u.username = "' . $username . '"';
        $stmt = $this->db->query($sql);
        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = new ItemEntity($row);
        }
        return $results;
    }


    public function getItemById($username, $item_id)
    {
        $sql = "SELECT i.id, i.name, i.done, u.username
            from items i
            join users u on (u.id = i.user_id)
            where i.id = :item_id and u.username = :username";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["item_id" => $item_id, "username" =>$username]);
        if($result) {
            return new ItemEntity($stmt->fetch());
        }
    }


    public function deleteItemById($username, $item_id)
    {
        $sql = "DELETE FROM items
            WHERE id = :item_id AND user_id = (SELECT id FROM users WHERE username = :username)
            LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["item_id" => $item_id,
            "username" => $username]);

        /*
        if($this->getItemById($item_id)) {
            throw new Exception("could not delete record");
        }
        */
    }


    public function save(ItemEntity $item)
    {
        $sql = "INSERT INTO items
            (name, done, user_id) VALUES
            (:name, :done,
            (SELECT id FROM users WHERE username = :username))";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            "name" => $item->getName(),
            "done" => $item->getDone(),
            "username" => $item->getUsername(),
        ]);

        if(!$result) {
            throw new Exception("could not save record");
        }
    }


    public function update(ItemEntity $item)
    {

        $sql = "UPDATE items
            SET name = :name,
                done = :done
            WHERE id = :item_id AND user_id = (SELECT id FROM users WHERE username = :username);";
        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            "item_id" => $item->getId(),
            "name" => $item->getName(),
            "done" => $item->getDone(),
            "username" => $item->getUsername()
        ]);

        if(!$result) {
            throw new Exception("could not save record");
        }
    }
}