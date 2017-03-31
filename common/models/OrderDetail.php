<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_detail".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $content_id
 * @property integer $price
 * @property integer $total
 * @property integer $sale
 * @property integer $price_promotion
 * @property integer $number
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $code
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
            ['code','string'],
            [['order_id', 'content_id', 'price','sale', 'price_promotion', 'number', 'total','created_at', 'updated_at'], 'integer'],
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
            'content_id' => 'Sản phẩm',
            'code' => 'Mã sản phẩm',
            'price' => 'Giá gốc',
            'price_promotion' => 'Giá giảm',
            'total' => 'Tổng tiền',
            'sale' => 'Giảm giá',
            'number' => 'Số lượng',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày thay đổi',
        ];
    }
}
