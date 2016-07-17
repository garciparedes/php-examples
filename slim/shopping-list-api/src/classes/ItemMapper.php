<?php

class ItemMapper extends Mapper {


    public function getItems()
    {
        $sql = "SELECT i.id, i.name, i.done, u.username
            from items i
            join users u on (u.id = i.user_id)";
        $stmt = $this->db->query($sql);
        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = new ItemEntity($row);
        }
        return $results;
    }

    public function getItemById($item_id)
    {
        $sql = "SELECT i.id, i.name, i.done, u.username
            from items i
            join users u on (u.id = i.user_id)
            where i.id = :item_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["item_id" => $item_id]);
        if($result) {
            return new ItemEntity($stmt->fetch());
        }
    }


    public function save(ItemEntity $item)
    {
        $sql = "insert into items
            (name, done, user_id) values
            (:name, :done,
            (select id from users where username = :username))";

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

}
