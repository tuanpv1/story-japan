<?php
/**
 * Created by PhpStorm.
 * User: thuc
 * Date: 10/17/14
 * Time: 3:39 PM
 */

namespace frontend\models;


use common\models\Subcriber;
use Yii;
use yii\web\Cookie;

class UserHelper {
    const SESSION_USER_ID = 'id';
    const SESSION_USER_NAME = 'user_name';
    const SESSION_FULL_NAME = 'full_name';
    const SESSION_GENDER= 'gender';
    const SESSION_PHONE_NUMBER = 'phone';
    const SESSION_EMAIL = 'email';
    const COOKIE_PASSWORD = 'password';
    const COOKIE_ADDRESS = 'address';
    public static function login($subscriber) { /** @var Subcriber $subscriber*/
        Yii::$app->session->set(UserHelper::SESSION_USER_ID, $subscriber->id);
        Yii::$app->session->set(UserHelper::SESSION_USER_NAME, $subscriber->user_name);
        Yii::$app->session->set(UserHelper::SESSION_FULL_NAME, $subscriber->full_name);
        Yii::$app->session->set(UserHelper::SESSION_GENDER, $subscriber->gender);
        Yii::$app->session->set(UserHelper::SESSION_EMAIL, $subscriber->email);
        Yii::$app->session->set(UserHelper::SESSION_PHONE_NUMBER, $subscriber->phone);
        Yii::$app->session->set(UserHelper::COOKIE_ADDRESS, $subscriber->address);
        //Set cookie
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'username',
            'value' => $subscriber->user_name,
            'expire' => time() + (86400 * 30),
        ]));
        $cookies->add(new Cookie([
            'name' => 'password',
            'value' => $subscriber->password_hash,
            'expire' => time() + (86400 * 30),
        ]));

    }
    /**
     * logout
     */
    public static function logout() {
        Yii::$app->session->remove(UserHelper::SESSION_USER_NAME);
        Yii::$app->session->destroy();
        Yii::warning("Logout: ". Yii::$app->session->get(UserHelper::SESSION_USER_NAME));
    }

//    public static function getAccessToken() {
//        return Yii::$app->session->get(UserHelper::SESSION_ACCESS_TOKEN);
//    }
}