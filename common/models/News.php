<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $display_name
 * @property string $short_description
 * @property string $description
 * @property string $image_display
 * @property string $content
 * @property int $type
 * @property int $created_at
 * @property int $status
 * @property int $updated_at
 * @property int $created_user_id
 */
class News extends \yii\db\ActiveRecord
{
    const TYPE_BANNER = 1;
    const TYPE_NEWS = 2;
    const TYPE_ABOUT = 3;
    const TYPE_CONTACT = 4;

    const STATUS_NEW = 1;
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = 2;

    const IS_SLIDE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'image_display', 'content'], 'string'],
            [['type', 'created_at', 'status', 'updated_at', 'created_user_id'], 'integer'],
            [['display_name', 'short_description'], 'string', 'max' => 500],
            [['short_description', 'display_name', 'content'], 'required', 'message' => Yii::t('app', '{attribute} không được để trống')],
            ['image_display', 'required', 'on' => 'create'],
            [['image_display'],
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
            'display_name' => Yii::t('app', 'Tên hiển thị'),
            'short_description' => Yii::t('app', 'Mô tả ngắn'),
            'description' => Yii::t('app', 'Nội dung chi tiết'),
            'image_display' => Yii::t('app', 'Hình ảnh đại diện'),
            'content' => Yii::t('app', 'Nội dung'),
            'type' => Yii::t('app', 'Loại'),
            'created_at' => Yii::t('app', 'Ngày tạo'),
            'status' => Yii::t('app', 'Trạng thái'),
            'updated_at' => Yii::t('app', 'Ngày thay đổi thông tin'),
            'created_user_id' => Yii::t('app', 'Người tạo'),
        ];
    }

    public static function listStatus()
    {
        $lst = [
            self::STATUS_NEW => Yii::t('app', 'Soạn thảo'),
            self::STATUS_ACTIVE => Yii::t('app', 'Hoạt động'),
            self::STATUS_INACTIVE => Yii::t('app', 'Tạm dừng'),
        ];
        return $lst;
    }

    /**
     * @return array
     */

    /**
     * @return int
     */
    public function getStatusName()
    {
        $lst = self::listStatus();
        if (array_key_exists($this->status, $lst)) {
            return $lst[$this->status];
        }
        return $this->status;
    }

    public static function listStatusType()
    {
        $lst = [
            self::TYPE_NEWS => Yii::t('app', 'Tin tức'),
            self::TYPE_BANNER => Yii::t('app', 'Tin tức banner'),
            self::TYPE_CONTACT => Yii::t('app', 'Thông tin liên hệ'),
            self::TYPE_ABOUT => Yii::t('app', 'Giới thiệu'),
        ];
        return $lst;
    }

    public static function getTypeName($type)
    {
        $lst = self::listStatusType();
        if (array_key_exists($type, $lst)) {
            return $lst[$type];
        }
        return $type;
    }

    public function getImageDisplayLink()
    {
        $pathLink = Yii::getAlias('@web') . '/' . Yii::getAlias('@image_news') . '/';
        $filename = null;

        if ($this->image_display) {
            $filename = $this->image_display;

        }
        if ($filename == null) {
            $pathLink = Yii::getAlias("@web/img/");
            $filename = 'bg_df.png';
        }

        return Url::to($pathLink . $filename, true);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    public function getUserCreated()
    {
        $user = User::findOne($this->created_user_id);
        if (!$user) {
            return 'Đang cập nhật';
        }
        return $user->username;
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
