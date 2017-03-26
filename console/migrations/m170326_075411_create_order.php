<?php

use yii\db\Migration;

class m170326_075411_create_order extends Migration
{
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'status' => $this->integer(3),
            'name_buyer' => $this->string(),
            'phone_buyer' => $this->integer(),
            'address_buyer' => $this->string(),
            'email_buyer' => $this->string(),
            'email_receiver' => $this->string(),
            'name_receiver' => $this->string(),
            'phone_receiver' => $this->integer(),
            'address_receiver' => $this->string(),
            'total' => $this->integer(),
            'total_number' => $this->integer(),
            'created_at' => $this->integer(),
            'note' => $this->text(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('order');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
