<?php
use common\models\Content;
use common\models\Order;
use common\models\Subscriber;
use common\models\User;
use kartik\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
/** @var \common\models\Order $model */
?>
<div class="tabbable-custom ">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => !empty($model->user_id)?Subscriber::findOne($model->user_id)->username:Yii::t('app','Khách hàng không đăng kí tài khoản'),
            ],
            [
                'attribute' => 'total',
                'value' => \common\helpers\CUtils::formatNumber($model->total).' VND',
            ],
            [
                'attribute' => 'total_number',
                'value' => $model->total_number.' Sản phẩm',
            ],
            [
                'attribute' => 'name_buyer',
                'value' => $model->name_buyer,
            ],
            [
                'attribute' => 'email_buyer',
                'value' => $model->email_buyer,
            ],
            [
                'attribute' => 'phone_buyer',
                'value' => $model->phone_buyer,
            ],
            [
                'attribute' => 'address_buyer',
                'value' => $model->address_buyer,
            ],
            [
                'attribute' => 'name_receiver',
                'value' => $model->name_receiver,
            ],
            [
                'attribute' => 'phone_receiver',
                'value' => $model->phone_receiver,
            ],
            [
                'attribute' => 'address_receiver',
                'value' => $model->address_receiver,
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => Order::getStatus($model->status),
            ],
            [
                'attribute' => 'note',
                'value' => $model->note,
            ],
            [
                'attribute' => 'pay',
                'value' => $model->pay . ' VND',
            ],
            [
                'attribute' => 'date_pay',
                'value' => $model->date_pay?date('d/m/Y H:i:s', $model->date_pay):'',
            ],
            [
                'attribute' => 'book',
                'value' => $model->book . ' VND',
            ],
            [                      // the owner name of the model
                'attribute' => 'created_at',
                'label' => 'Ngày đặt',
                'value' => date('d/m/Y H:i:s', $model->created_at),
            ],
            [                      // the owner name of the model
                'attribute' => 'updated_at',
                'label' => 'Ngày thay đổi thông tin',
                'value' => date('d/m/Y H:i:s', $model->updated_at),
            ],
        ],
    ]) ?>
</div>