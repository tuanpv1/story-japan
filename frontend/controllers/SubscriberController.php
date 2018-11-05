<?php

namespace frontend\controllers;

use common\models\Order;
use common\models\OrderDetail;
use common\models\Subscriber;
use DateTime;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class SubscriberController extends Controller
{
    public function actionInfo()
    {
        $id = Yii::$app->user->id;
        $model = Subscriber::findOne($id);
        if ($model) {
            $orders = Order::find()
                ->andWhere(['user_id' => $id])
                ->all();
            return $this->render('info', [
                'model' => $model,
                'orders' => $orders
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
                ->select('order_detail.*,content.display_name,content.images')
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
}