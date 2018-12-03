<?php

use yii\db\Migration;

/**
 * Handles adding payment_type to table `info_public`.
 */
class m181202_074330_add_payment_type_column_to_info_public_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('info_public', 'payment_type', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('info_public', 'payment_type');
    }
}
