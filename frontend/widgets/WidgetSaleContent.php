<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/19/2016
 * Time: 9:09 PM
 */

namespace frontend\widgets;

use common\models\Content;
use yii\base\Widget;

class WidgetSaleContent extends Widget
{
    public $id;
    public $message;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
        // sản phẩm sale
        $product_sales = Content::find()
            ->select('content.id,content.display_name,content.type,content.short_description,content.price,content.images,content.price_promotion')
            ->andWhere(['content.status' => Content::STATUS_ACTIVE])
            ->andWhere(['content.type' => Content::TYPE_NEWEST])
            ->andWhere(['<>', 'content.id', $this->id])
            ->orderBy(['content.created_at' => 'DESC'])
            ->limit(3)
            ->all();
        return $this->render('widget-sale-content', [
            'product_sales' => $product_sales,
        ]);
    }
}
