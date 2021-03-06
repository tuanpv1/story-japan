<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/19/2016
 * Time: 9:09 PM
 */
namespace frontend\widgets;

use common\models\SubscriberFavorite;
use common\models\User;
use yii\base\Widget;
use Yii;

class UserWidget extends Widget{

    public $message;
    public $model;

    public  function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public  function run()
    {
        $favourite_count = SubscriberFavorite::find()->andWhere(['subscriber_id' => $this->model->id])->count();
        return $this->render('user-widget',[
            'model'=>$this->model,
            'favourite_count' => $favourite_count
        ]);
    }
}
