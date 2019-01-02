<?php
namespace frontend\models;

use common\models\Subscriber;
use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $fullname;
    public $address;
    public $email;
    public $password;
    public $confirm_password;
    public $type;
    public $phone_number;
    public $captcha;
    public $accept;
    public $birthday;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username'], 'required','message'=>'Tên đăng nhập không được để trống.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác!'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required','message'=>'Tên đăng nhập không được để trống.'],
            ['birthday', 'default', 'value' => null],
            ['email', 'email', 'message' => 'Địa chỉ email không hợp lệ!'],
//            ['captcha', 'required', 'message' => 'Mã captcha không được để trống.'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Tài khoản email của bạn đã được đăng ký trên hệ thống!'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Mật khẩu phải tối thiểu 6 ký tự'],
            ['confirm_password', 'required','message'=>'Xác nhận mật khẩu không được để trống.'],
            ['password','required','message'=>'Mật khẩu không được để trống.'],

            [
                ['confirm_password'],
                'compare',
                'compareAttribute' => 'password',
                'message' => 'Xác nhận mật khẩu không khớp',

            ],
//            ['accept', 'compare', 'compareValue' => 1, 'message' => ''],
            [['address'], 'safe'],
//            [['captcha'], 'captcha'],
            [['phone_number'], 'integer', 'message' => 'Số điện thoại phải là kiểu số'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app','Username'),
            'phone_number' =>  Yii::t('app','Phone'),
            'email' => Yii::t('app','Email'),
            'address' => Yii::t('app','Address'),
            'password' => Yii::t('app','Password'),
            'confirm_password' => Yii::t('app','Confirm password'),
            'captcha' =>Yii::t('app','Captcha'),
//            'accept' => 'Vui lòng đồng ý với quy định và điều khoản của trang (*)'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new Subscriber();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->address = $this->address;
        $user->phone = $this->phone_number;
        $user->status = subscriber::STATUS_ACTIVE;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save(false) ? $user : null;

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
