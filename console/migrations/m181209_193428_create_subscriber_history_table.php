<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subscriber_history`.
 */
class m181209_193428_create_subscriber_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('subscriber_history', [
            'id' => $this->primaryKey(),
            'subscriber_id' => $this->integer(),
            'content_id' => $this->integer(),
            'time_read' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('subscriber_history');
    }
}
