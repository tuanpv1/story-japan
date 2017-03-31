<?php

use yii\db\Migration;

class m170331_075948_rename_column_product_id_order_detail_table extends Migration
{
    public function up()
    {
        echo "    > rename column product_id in table order_detail to content_id ...";
        $time = microtime(true);
        $this->db->createCommand()->renameColumn('order_detail', 'product_id', 'content_id')->execute();
        $this->db->createCommand()->renameColumn('order_detail', 'price_sale', 'price_promotion')->execute();
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    public function down()
    {
        echo "m170331_075948_rename_column_product_id_order_detail_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
