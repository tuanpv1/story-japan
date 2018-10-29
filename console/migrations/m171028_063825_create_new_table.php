<?php

use yii\db\Migration;

/**
 * Handles the creation of table `new`.
 */
class m171028_063825_create_new_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'display_name' => $this->string(500),
            'short_description' => $this->string(500),
            'description' => $this->text(),
            'image_display' => $this->text(),
            'content' => $this->text(),
            'type' => $this->integer(11),
            'created_at' => $this->integer(11),
            'status' => $this->integer(11),
            'updated_at' => $this->integer(11)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('news');
    }
}
