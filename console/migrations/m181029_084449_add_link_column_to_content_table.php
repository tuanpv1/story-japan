<?php

use yii\db\Migration;

/**
 * Handles adding link to table `content`.
 */
class m181029_084449_add_link_column_to_content_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('content', 'link', $this->string(5000));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('content', 'link');
    }
}
