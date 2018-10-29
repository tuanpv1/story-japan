<?php

namespace frontend\controllers;

use api\models\Subscriber;
use common\models\Content;
use common\models\News;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class NewsController extends Controller
{
    public function actionIndex()
    {
        $this->layout = 'main-blog';

        $newsQuery = News::find()
            ->andWhere(['status' => News::STATUS_ACTIVE])
            ->andWhere(['type' => News::TYPE_NEWS])
            ->orderBy(['updated_at' => SORT_DESC]);
        $countQuery = clone $newsQuery;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $news = $newsQuery->offset($pages->offset)
            ->limit(12)->all();

        return $this->render('index', [
            'news' => $news,
            'pages' => $pages,
        ]);
    }

    public function actionDetail($id)
    {
        $new = News::findOne(['id' => $id, 'status' => Content::STATUS_ACTIVE]);
        if (!$new) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        // Lấy tin tức liên quan
        $relatedNews = News::find()
            ->andWhere(['status' => News::STATUS_ACTIVE])
            ->andWhere(['type' => News::TYPE_NEWS])
            ->andWhere(['<>', 'id', $id])
            ->orderBy(['updated_at' => SORT_DESC])
            ->limit(6)
            ->all();
        return $this->render('detail', [
            'new' => $new,
            'relatedNews' => $relatedNews
        ]);
    }
}