<?php

namespace frontend\controllers;

use api\models\Subscriber;
use common\models\Content;
use common\models\News;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class NewsController extends Controller
{
    public function actionAbout()
    {
        $new = News::findOne(['type' => News::TYPE_ABOUT, 'status' => Content::STATUS_ACTIVE]);
        if (!$new) {
            \Yii::$app->session->setFlash('error',Yii::t('app','Chưa cập nhật thông tin'));
            return $this->redirect(['site/index']);
        }
        return $this->render('detail', [
            'new' => $new,
        ]);
    }

    public function actionContact()
    {
        $new = News::findOne(['type' => News::TYPE_CONTACT, 'status' => Content::STATUS_ACTIVE]);
        if (!$new) {
            \Yii::$app->session->setFlash('error',Yii::t('app','Chưa cập nhật thông tin'));
            return $this->redirect(['site/index']);
        }
        return $this->render('detail', [
            'new' => $new,
        ]);
    }
}