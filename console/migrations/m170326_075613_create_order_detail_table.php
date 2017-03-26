<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_detail`.
 */
class m170326_075613_create_order_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_detail', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'price' => $this->integer(),
            'sale' => $this->integer(),
            'price_sale' => $this->integer(),
            'number' => $this->integer(),
            'total' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_detail');
    }
}
