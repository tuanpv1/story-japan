<?php

use yii\db\Migration;

class m170325_044436_add_column_is_feature_content extends Migration
{
    public function up()
    {
        $this->addColumn('content','is_feature','int');
    }

    public function down()
    {
        echo "m170325_044436_add_column_is_feature_content cannot be reverted.\n";

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
