<?php

use yii\db\Migration;

/**
 * Handles adding time_show_order to table `info_public`.
 */
class m181101_032813_add_time_show_order_column_to_info_public_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('info_public', 'time_show_order', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('info_public', 'time_show_order');
    }
}
