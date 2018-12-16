<?php
/**
 * Created by PhpStorm.
 * User: TuanPV
 * Date: 12/17/2018
 * Time: 12:43 AM
 */

namespace frontend\models;


use Yii;
use yii\base\Behavior;

class CheckLanguage extends Behavior
{
    public function events(){
        return [
            \yii\web\Application::EVENT_BEFORE_REQUEST => 'changeLanguage'
        ];
    }

    public function changeLanguage(){
        if(Yii::$app->getRequest()->getCookies()->has('language')){
            Yii::$app->language = Yii::$app->getRequest()->getCookies()->getValue('language');
        }
    }
}