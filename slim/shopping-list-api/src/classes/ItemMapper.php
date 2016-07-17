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
}
