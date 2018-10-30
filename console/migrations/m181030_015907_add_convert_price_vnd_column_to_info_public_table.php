<?php

use yii\db\Migration;

/**
 * Handles adding convert_price_vnd to table `info_public`.
 */
class m181030_015907_add_convert_price_vnd_column_to_info_public_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('info_public', 'convert_price_vnd', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('info_public', 'convert_price_vnd');
    }
}
