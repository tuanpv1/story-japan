<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/19/2016
 * Time: 9:09 PM
 */

namespace frontend\widgets;

use common\models\InfoPublic;
use Yii;
use yii\base\Widget;
use yii\web\NotFoundHttpException;

class FooterWidget extends Widget
{

    public $message;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function run()
    {
        $info = InfoPublic::findOne(InfoPublic::ID_DEFAULT);
        if (!$info) {
            throw new NotFoundHttpException(Yii::t('app', 'Chưa được cài đặt thông số tĩnh xin cập nhật từ trang quản trị'));
        }
        return $this->render('footer-widget', ['info' => $info]);
    }
}
