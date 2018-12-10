<?php

namespace frontend\controllers;

use common\models\Content;
use common\models\Order;
use common\models\OrderDetail;
use common\models\Subscriber;
use common\models\SubscriberFavorite;
use common\models\SubscriberHistory;
use DateTime;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class SubscriberController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionInfo()
    {
        $id = Yii::$app->user->id;
        $model = Subscriber::findOne($id);
        if ($model) {
            $histories = SubscriberHistory::find()
                ->select('content.code, content.images,content.display_name,content.parent_id,subscriber_history.*')
                ->innerJoin('content', 'content.id = subscriber_history.content_id')
                ->andWhere(['subscriber_history.subscriber_id' => $id])
                ->orderBy(['time_again' => SORT_DESC, 'time_read' => SORT_DESC])
                ->all();
            return $this->render('info', [
                'model' => $model,
                'histories' => $histories
            ]);
        } else {
            return $this->redirect(['site/index#myModal']);
        }
    }

    public function actionOrderDetail($id)
    {
        $idUser = Yii::$app->user->id;
        $model = Subscriber::findOne($idUser);
        if ($model) {
            $order = Order::findOne($id);
            $orderDetails = OrderDetail::find()
                ->select('order_detail.*,content.display_name,content.images as image')
                ->innerJoin('content', 'content.id = order_detail.content_id')
                ->andWhere(['order_id' => $id])->all();
            return $this->render('order-detail', [
                'model' => $model,
                'order' => $order,
                'orderDetails' => $orderDetails
            ]);
        } else {
            return $this->redirect(['site/index#myModal']);
        }
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

    public function actionUpdate()
    {
        $id = Yii::$app->user->id;

        $model = subscriber::find()->andWhere(['id' => $id])->andWhere(['status' => subscriber::STATUS_ACTIVE])->one();
        /* @var $model Subscriber */
        if (!$model) {
            return $this->redirect(['site/index#myModal']);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $model->birthday = $model->birthday ? date('d/m/Y', strtotime($model->birthday)) : '';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->birthday = $model->birthday ? date('Y-m-d H:i:s', strtotime(DateTime::createFromFormat("d/m/Y", $model->birthday)->setTime(0, 0)->format('Y-m-d H:i:s'))) : '';
            $model->save(false);
            Yii::$app->getSession()->setFlash('success', 'Cập nhật thành công thông tin người dùng');
            return $this->redirect(['info']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionAddFavourite()
    {
        $content_id = Yii::$app->request->post('content_id');
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->user->isGuest) {
            return ['success' => false, 'message' => Yii::t('app', 'Login required')];
        }
        if ($content_id) {
            $subscriberFavourite = New SubscriberFavorite();
            $subscriberFavourite->subscriber_id = Yii::$app->user->id;
            $subscriberFavourite->content_id = $content_id;
            $subscriberFavourite->save();
            // update lại favourite count content
            $content = Content::findOne($content_id);
            if ($content) {
                $content->favorite_count = $content->favorite_count + 1;
                $content->update(false);
            }
            return ['success' => true, 'message' => Yii::t('app', 'Add success')];
        }
    }

    public function actionRemoveFavourite()
    {
        $content_id = Yii::$app->request->post('content_id');
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->user->isGuest) {
            return ['success' => false, 'message' => Yii::t('app', 'Login required')];
        }
        if ($content_id) {
            $subscriberFavourite = SubscriberFavorite::find()
                ->andWhere(['content_id' => $content_id])
                ->andWhere(['subscriber_id' => Yii::$app->user->id])
                ->one();
            $subscriberFavourite->delete();
            // update lại favourite count content
            $content = Content::findOne($content_id);
            if ($content) {
                $content->favorite_count = $content->favorite_count - 1;
                $content->update(false);
            }
            return ['success' => true, 'message' => Yii::t('app', 'Remove success')];
        }
    }

    public function actionFavourite()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = Subscriber::findOne(Yii::$app->user->id);
        $contents = Content::find()
            ->select('content.*')
            ->innerJoin('subscriber_favorite', 'subscriber_favorite.content_id = content.id')
            ->andWhere(['subscriber_favorite.subscriber_id' => Yii::$app->user->id]);
        $contents->orderBy(['subscriber_favorite.created_at' => 'DESC']);
        $countQuery = clone $contents;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pageSize = 9;
        $pages->setPageSize($pageSize);
        $contents = $contents->offset($pages->offset)
            ->limit(9)->all();
        return $this->render('favourite', [
            'contents' => $contents,
            'model' => $model,
            'pages' => $pages,
        ]);
    }
}