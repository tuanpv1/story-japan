<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

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
    public $display_name;
    public $image;

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
            ['code', 'string'],
            [['order_id', 'content_id', 'price', 'sale', 'price_promotion', 'number', 'total', 'created_at', 'updated_at'], 'integer'],
            [['display_name', 'image'], 'safe']
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

    public function getImageContent()
    {
        $content = Content::findOne($this->content_id);
        if ($content) {
            return $content->getFirstImageLinkFE('product-100x122.jpg');
        } else {
            return Url::to(Url::base() . '/' . Yii::getAlias('data') . '/product-100x122.jpg', true);
        }
    }

    public function getContentName()
    {
        $content = Content::findOne($this->content_id);
        if ($content) {
            return $content->display_name;
        } else {
            return '';
        }
    }

    public function beforeValidate()
    {
        foreach (array_keys($this->getAttributes()) as $attr){
            if(!empty($this->$attr)){
                $this->$attr = \yii\helpers\HtmlPurifier::process($this->$attr);
            }
        }
        return parent::beforeValidate();// to keep parent validator available
    }
}
