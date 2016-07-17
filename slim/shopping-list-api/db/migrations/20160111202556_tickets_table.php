<?php

use Phinx\Migration\AbstractMigration;

class TicketsTable extends AbstractMigration {

    public function up()
    {
        $users_table = $this->table('users');
        $users_table->addColumn('username','string')
            ->addColumn('password', 'string')
            ->create();

        $users_table->insert([
            [
                "username" => "garciparedes",
                "password" => "1234"
            ],
            [
                "username" => "juancho",
                "password" => "1234"
            ]
        ]);
        $users_table->saveData();

        $items_table = $this->table('items');
        $items_table->addColumn('name', 'string')
            ->addColumn('done', 'boolean')
            ->addColumn('user_id', 'integer')
            ->addForeignKey('user_id', 'users', 'id')
            ->create();


        $items_table->insert([
            [
                "name" => "tomatoes",
                "done" => "1",
                "user_id" => "1"
            ],
            [
                "name" => "sugar",
                "done" => "0",
                "user_id" => "1"
            ],
            [
                "name" => "rice",
                "done" => "0",
                "user_id" => "1"
            ],
            [
                "name" => "milk",
                "done" => "0",
                "user_id" => "1"
            ]
        ]);
        $items_table->saveData();
    }

    public function down()
    {
        $this->dropTable('users');
        $this->dropTable('itemss');
    }
}
