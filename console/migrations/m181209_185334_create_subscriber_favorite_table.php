<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subscriber_favorite`.
 */
class m181209_185334_create_subscriber_favorite_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('subscriber_favorite', [
            'id' => $this->primaryKey(),
            'subscriber_id' => $this->integer(),
            'content_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('subscriber_favorite');
    }
}
