<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property string $name_buyer
 * @property integer $phone_buyer
 * @property string $address_buyer
 * @property string $email_buyer
 * @property string $email_receiver
 * @property string $name_receiver
 * @property integer $phone_receiver
 * @property integer $total
 * @property integer $total_number
 * @property string $address_receiver
 * @property integer $created_at
 * @property string $note
 * @property integer $updated_at
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_SUCCESS = 10; // đã nhận tiền kết thúc
    const STATUS_TRANSPORT = 9; // đang chuyển đi
    const STATUS_ERROR = 8; // thất lạc
    const STATUS_RETURN = 7; // hoàn trả
    const STATUS_ORDERED = 6; // vừa đặt hàng xong

    public  function  getListStatus(){
        $list1 = [
            self::STATUS_SUCCESS => 'Đã nhận hàng',
            self::STATUS_TRANSPORT => 'Đang chuyển đi',
            self::STATUS_ERROR => 'Thất lạc',
            self::STATUS_RETURN => 'Trả lại',
            self::STATUS_ORDERED => 'Vừa đặt hàng',
        ];

        return $list1;
    }

    public function getStatusName()
    {
        $lst = self::getListStatus();
        if (array_key_exists($this->status, $lst)) {
            return $lst[$this->status];
        }
        return $this->status;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
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
            [['user_id', 'status', 'phone_buyer', 'phone_receiver','total_number','total', 'created_at', 'updated_at'], 'integer'],
            [['note'], 'string'],
            [['name_buyer', 'address_buyer', 'email_buyer', 'name_receiver', 'address_receiver', 'email_receiver'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mã',
            'user_id' => 'Tên tài khoản',
            'status' => 'Trạng thái',
            'name_buyer' => 'Tên người mua',
            'phone_buyer' => 'Số điện thoại người mua',
            'address_buyer' => 'Địa chỉ người mua',
            'email_buyer' => 'Email người mua',
            'name_receiver' => 'Tên người nhận',
            'phone_receiver' => 'Số điện thoại người nhận',
            'address_receiver' => 'Địa chỉ người nhận',
            'created_at' => 'Ngày tạo',
            'note' => 'Ghi chú người mua',
            'total' => 'Tổng tiền',
            'total_number' => 'Tổng sản phẩm',
            'updated_at' => 'Ngày thay đổi',
        ];
    }

    public function getStatus($status){
        if($status == self::STATUS_ERROR){
            return '<span class="label label-danger">' . Order::getStatusNameID($status) . '</span>';
        }
        if($status == self::STATUS_SUCCESS){
            return '<span class="label label-success">' . Order::getStatusNameID($status) . '</span>';
        }
        if($status == self::STATUS_RETURN){
            return '<span class="label label-default">' . Order::getStatusNameID($status) . '</span>';
        }
        if($status == self::STATUS_TRANSPORT){
            return '<span class="label label-warning">' . Order::getStatusNameID($status) . '</span>';
        }
        if($status == self::STATUS_ORDERED){
            return '<span class="label label-primary">' . Order::getStatusNameID($status) . '</span>';
        }
    }

    public static function getStatusNameID($status)
    {
        $lst = self::getListStatus();
        if (array_key_exists($status, $lst)) {
            return $lst[$status];
        }
        return $status;
    }
}
