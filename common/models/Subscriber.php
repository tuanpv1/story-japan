<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "subscriber".
 *
 * @property integer $id
 * @property integer $id_facebook
 * @property string $username
 * @property string $full_name
 * @property integer $gender
 * @property integer $status
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $address
 * @property integer $phone
 * @property string $birthday
 * @property string $about
 * @property integer $created_at
 * @property integer $updated_at
 */
class Subscriber extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 1;
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 0;

    public static function listStatus()
    {
        $lst = [
            self::STATUS_ACTIVE => Yii::t('app', 'Kích hoạt'),
            self::STATUS_INACTIVE => Yii::t('app', 'Tạm dừng'),
        ];
        return $lst;
    }

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

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_OTHER = 3;

    public static function listGender()
    {
        $gender = [
            self::GENDER_MALE => Yii::t('app', 'Male'),
            self::GENDER_FEMALE => Yii::t('app', 'Female'),
            self::GENDER_OTHER => Yii::t('app', 'Other'),
        ];
        return $gender;
    }

    public function getGenderName()
    {
        $lst = self::listGender();
        if (array_key_exists($this->gender, $lst)) {
            return $lst[$this->gender];
        }
        return $this->gender;
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

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscriber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender', 'status', 'phone', 'created_at', 'updated_at', 'id_facebook'], 'integer'],
//            [['auth_key', 'password_hash', 'email'], 'required'],
            [['birthday'], 'safe'],
            [['username', 'full_name', 'password_hash', 'password_reset_token', 'email', 'address'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['about'], 'string', 'max' => 600],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Mã'),
            'username' => Yii::t('app', 'Tên đăng nhập'),
            'full_name' => Yii::t('app', 'Tên đầy đủ '),
            'gender' => Yii::t('app', 'Giới tính'),
            'status' => Yii::t('app', 'Trạng thái'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Địa chỉ Email'),
            'address' => Yii::t('app', 'Địa chỉ'),
            'phone' => Yii::t('app', 'Số điện thoại'),
            'birthday' => Yii::t('app', 'Ngày sinh'),
            'about' => Yii::t('app', 'Giới thiệu'),
            'created_at' => Yii::t('app', 'Ngày tạo'),
            'updated_at' => Yii::t('app', 'Ngày thay đổi thông tin'),
            'id_facebook' => Yii::t('app', 'Tài khoản facebook'),
        ];
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function getImageLink()
    {
//        $pathLink = Yii::getAlias('@web') . '/' . Yii::getAlias('@image_avatar') . '/';
//        $filename = null;
//        if (!$filename) {
        $pathLink = Url::base() . '/images/avt_df.png';
//        }
        $link = Url::to($pathLink);
        return $link;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->getPrimaryKey();
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateAccessLoginToken()
    {
        $this->access_login_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function beforeValidate()
    {
        foreach (array_keys($this->getAttributes()) as $attr) {
            if (!empty($this->$attr)) {
                $this->$attr = \yii\helpers\HtmlPurifier::process($this->$attr);
            }
        }
        return parent::beforeValidate();// to keep parent validator available
    }
}
