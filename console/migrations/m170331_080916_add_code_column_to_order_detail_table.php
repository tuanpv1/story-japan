<?php

use yii\db\Migration;

/**
 * Handles adding code to table `order_detail`.
 */
class m170331_080916_add_code_column_to_order_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('order_detail', 'code', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('order_detail', 'code');
    }
}
