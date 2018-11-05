<?php

use yii\db\Migration;

/**
 * Handles adding max_price_search to table `info_public`.
 */
class m181103_034442_add_max_price_search_column_to_info_public_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('info_public', 'max_price_search', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('info_public', 'max_price_search');
    }
}
