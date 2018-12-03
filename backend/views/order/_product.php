<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/24/2016
 * Time: 6:20 PM
 */
use common\helpers\CUtils;
use common\models\Content;
use common\models\Order;
use common\models\Subscriber;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Html;

?>
<button onclick="printContent('print_order')" class="btn btn-success">In hoá đơn</button>
<div style="display: none" id="print_order">
    <div class="text-center">
        <h2> Thông tin đơn hàng mã #<?= $model->id ?></h2>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'user_id',
                'value' => !empty($model->user_id) ? Subscriber::findOne($model->user_id)->username : Yii::t('app', 'Khách hàng không đăng kí tài khoản'),
            ],
            [
                'attribute' => 'total',
                'value' => \common\helpers\CUtils::formatNumber($model->total) . ' VND',
            ],
            [
                'attribute' => 'total_number',
                'value' => $model->total_number . ' Sản phẩm',
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
                'visible' => $model->name_receiver ? true : false,
                'value' => $model->name_receiver,
            ],
            [
                'attribute' => 'phone_receiver',
                'visible' => $model->phone_receiver ? true : false,
                'value' => $model->phone_receiver,
            ],
            [
                'attribute' => 'address_receiver',
                'visible' => $model->address_receiver ? true : false,
                'value' => $model->address_receiver,
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => Order::getStatus($model->status),
            ],
            [
                'attribute' => 'book',
                'value' => $model->book,
            ],
            [
                'attribute' => 'note',
                'value' => $model->note,
            ],
            [                      // the owner name of the model
                'attribute' => 'created_at',
                'label' => 'Ngày đặt hàng',
                'value' => date('d/m/Y H:i:s', $model->created_at),
            ],
        ],
    ]) ?>

    <br>
    <b>Thông tin sản phẩm</b><br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showPageSummary' => true,
        'layout' => '{items}\n{pager}',
        'columns' => [
            [
                'class' => '\kartik\grid\DataColumn',
                'label' => 'Ảnh SP',
                'format' => 'raw',
                'contentOptions' => ['style' => ['max-width' => '15px'], 'class' => 'text-wrap'],
                'value' => function ($model, $key, $index, $widget) {
                    $link = Content::findOne($model->content_id)->getFirstImageLink();
                    return $link ? Html::img($link, ['alt' => 'Thumbnail', 'width' => '50', 'height' => '50']) : '';
                },
                'pageSummary' => Yii::t("app", "Tổng tiền")
            ],
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'content_id',
                'enableSorting' => false,
                'contentOptions' => ['style' => ['max-width' => '100px'], 'class' => 'text-wrap'],
                'format' => 'html',
                'value' => function ($model, $key, $index, $widget) {
                    return Content::findOne($model->content_id)->display_name;
                },
            ],
            [
                'class' => '\kartik\grid\DataColumn',
                'contentOptions' => ['style' => ['max-width' => '20px'], 'class' => 'text-wrap'],
                'attribute' => 'price_promotion',
                'enableSorting' => false,
                'label' => 'Giá bán',
                'format' => 'html',
                'value' => function ($model, $key, $index, $widget) {
                    return CUtils::formatNumber($model->price_promotion) . ' Đ';
                },
            ],
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'number',
                'enableSorting' => false,
                'contentOptions' => ['style' => ['max-width' => '20px'], 'class' => 'text-wrap'],
                'value' => function ($model, $key, $index, $widget) {
                    return $model->number . ' Sản phẩm';
                },
                'pageSummary' => CUtils::formatNumber($model->total_number) . ' Sản phẩm'
            ],
            [
                'class' => '\kartik\grid\DataColumn',
                'enableSorting' => false,
                'attribute' => 'total',
                'contentOptions' => ['style' => ['max-width' => '20px'], 'class' => 'text-wrap'],
                'value' => function ($model, $key, $index, $widget) {
                    return CUtils::formatNumber($model->total) . ' Đ';
                },
                'pageSummary' => CUtils::formatNumber($model->total) . ' Đ'
            ]
        ],
    ]);?>
</div>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'showPageSummary' => true,
    'columns' => [
        [
            'class' => '\kartik\grid\DataColumn',
            'label' => 'Ảnh SP',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $widget) {
                $link = Content::findOne($model->content_id)->getFirstImageLink();
                return $link ? Html::img($link, ['alt' => 'Thumbnail', 'width' => '50', 'height' => '50']) : '';
            },
            'pageSummary' => Yii::t("app", "Tổng tiền")
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'content_id',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return "<a class ='label label-primary' target='_blank' href='" . Yii::$app->params['preview_link'] . 'content/preview&id=' . $model->content_id . "'>" . Content::findOne($model->content_id)->display_name . "</a>";
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'price_promotion',
            'label' => 'Giá bán',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return CUtils::formatNumber($model->price_promotion) . ' Đ';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'number',
            'value' => function ($model, $key, $index, $widget) {
                return $model->number . ' Sản phẩm';
            },
            'pageSummary' => CUtils::formatNumber($model->total_number) . ' Sản phẩm'
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'total',
            'value' => function ($model, $key, $index, $widget) {
                return CUtils::formatNumber($model->total) . ' Đ';
            },
            'pageSummary' => CUtils::formatNumber($model->total) . ' Đ'
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'total',
            'label' => 'Nguồn hàng',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return "<a href='" . Content::findOne($model->content_id)->link . "'>Link</a>";
            },
        ],
    ],
]); ?>
<script>
    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>