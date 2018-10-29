<?php

use yii\db\Migration;

/**
 * Handles the creation of table `info_public`.
 */
class m170113_153403_create_info_public_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('info_public', [
            'id' => $this->primaryKey(),
            'image_header' => $this->string(),
            'image_footer' => $this->string(),
            'email' => $this->string(),
            'phone' => $this->string(),
            'link_face' => $this->string(),
            'google' => $this->string(),
            'address' => $this->string(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'youtube' => $this->string(),
            'twitter' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('info_public');
    }
}
