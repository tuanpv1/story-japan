<?php

use yii\db\Migration;

class m181029_080738_add_created_user_id_column_to_news extends Migration
{
    public function up()
    {
        $this->addColumn('news','created_user_id',$this->integer());
    }

    public function down()
    {
        echo "m181029_080738_add_created_user_id_column_to_news cannot be reverted.\n";

        return false;
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
