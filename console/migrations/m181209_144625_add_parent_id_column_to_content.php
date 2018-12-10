<?php

use yii\db\Migration;

/**
 * Class m181209_144625_add_parent_id_column_to_content
 */
class m181209_144625_add_parent_id_column_to_content extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('content','is_series',$this->integer()->defaultValue(0));
        $this->addColumn('content', 'parent_id',$this->integer()->defaultValue(null));
        $this->addColumn('content', 'created_user_id',$this->integer()->defaultValue(null));
        $this->addColumn('content', 'episode_order',$this->integer()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181209_144625_add_parent_id_column_to_content cannot be reverted.\n";

        return false;
    }
    */
}
