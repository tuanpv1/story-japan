<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "info_public".
 *
 * @property integer $id
 * @property string $image_header
 * @property string $image_footer
 * @property string $email
 * @property string $phone
 * @property string $link_face
 * @property string $google
 * @property string $youtube
 * @property string $twitter
 * @property string $address
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $convert_price_vnd
 * @property integer $time_show_order
 */
class InfoPublic extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10; // hien
    const STATUS_BLOCK = 1; //an
    const STATUS_DELETED = 0; //an

    const ID_DEFAULT = 1;

    public function getListStatus()
    {
        $list1 = [
            self::STATUS_ACTIVE => 'Hiện',
            self::STATUS_BLOCK => 'Ẩn',
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

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'info_public';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'convert_price_vnd', 'time_show_order'], 'integer'],
            [['image_header', 'image_footer', 'email', 'phone', 'link_face', 'address', 'youtube', 'twitter', 'google'], 'string', 'max' => 500],
            ['image_header', 'required', 'message' => Yii::t('app', '{attribute} không được để trống'), 'on' => 'create'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email', 'message' => Yii::t('app', '{attribute} không hợp lệ!')],
            [['image_footer', 'image_header'],
                'file',
                'tooBig' => Yii::t('app', '{attribute} vượt quá dung lượng cho phép. Vui lòng thử lại'),
                'wrongExtension' => Yii::t('app', '{attribute} không đúng định dạng'),
                'uploadRequired' => Yii::t('app', '{attribute} không được để trống'),
                'extensions' => 'png, jpg, jpeg, gif',
                'maxSize' => 1024 * 1024 * 10
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'image_header' => Yii::t('app', 'Hình ảnh logo'),
            'image_footer' => Yii::t('app', 'Hình ảnh logo footer'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Tel1'),
            'link_face' => Yii::t('app', 'Link facebook'),
            'google' => Yii::t('app', 'Link google'),
            'youtube' => Yii::t('app', 'Link youtube'),
            'twitter' => Yii::t('app', 'Link twitter'),
            'address' => Yii::t('app', 'Địa chỉ'),
            'status' => Yii::t('app', 'trạng thái'),
            'created_at' => Yii::t('app', 'Ngày tạo'),
            'updated_at' => Yii::t('app', 'Ngày thay đổi thông tin'),
            'convert_price_vnd' => Yii::t('app', 'Tỉ giá chuyển đổi'),
        ];
    }

    public static function getImage($image)
    {
        if ($image) {
            return Url::to(Yii::getAlias('@webroot') . '/' . Yii::getAlias('@image_info') . '/' . $image, true);
        }
    }

    public static function getImageFe($image)
    {
        if ($image) {
            $link = Url::to('@web/staticdata/image_info/' . $image, true);
            $link = str_replace('/staticdata/', '/admin/staticdata/', $link);
            return $link;
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
