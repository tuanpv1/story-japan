<?php

namespace frontend\controllers;

use api\models\Subscriber;
use common\models\Content;
use common\models\ContentCategoryAsm;
use common\models\News;
use common\models\Subcriber;
use DateTime;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\behaviors\TimestampBehavior;
use yii\db\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class NewsController extends Controller
{
    public function actionIndex(){
        $this->layout = 'main-blog';
        $news = News::find()
            ->andWhere(['status' => News::STATUS_ACTIVE])
            ->andWhere(['type' => News::TYPE_NEWS])
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();

        return $this->render('index',[
            'news'=>$news,
        ]);
    }

    public function actionDetail($id){
        $new = News::findOne(['id'=>$id,'status'=>Content::STATUS_ACTIVE]);
        if(!$new){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('detail',[
            'new'=>$new,
        ]);
    }
}