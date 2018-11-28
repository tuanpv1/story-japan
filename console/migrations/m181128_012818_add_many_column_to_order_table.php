<?php

use yii\db\Migration;

/**
 * Handles adding many to table `order`.
 */
class m181128_012818_add_many_column_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order','book', $this->integer()->defaultValue(0));
        $this->addColumn('order','pay', $this->integer()->defaultValue(0));
        $this->addColumn('order','date_pay', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
