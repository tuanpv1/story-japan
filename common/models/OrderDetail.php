<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_detail".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $price
 * @property integer $total
 * @property integer $sale
 * @property integer $price_sale
 * @property integer $number
 * @property integer $created_at
 * @property integer $updated_at
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_detail';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'price','sale', 'price_sale', 'number', 'total','created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'MaDH',
            'product_id' => 'Sản phẩm',
            'price' => 'Giá gốc',
            'price_sale' => 'Giá giảm',
            'total' => 'Tổng tiền',
            'sale' => 'Giảm giá',
            'number' => 'Số lượng',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày thay đổi',
        ];
    }
}
