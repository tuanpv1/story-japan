<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/24/2016
 * Time: 6:20 PM
 */
use common\models\Content;
use kartik\grid\GridView;
use yii\helpers\Html;
/** @var \common\models\OrderDetail $model */
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        [
            'class' => '\kartik\grid\DataColumn',
            'label' => 'Ảnh SP',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $widget) {
                $link = Content::getFirstImageLinkFeStatic(Content::findOne($model->content_id)->images);
                return $link ? Html::img($link, ['alt' => 'Thumbnail', 'width' => '50', 'height' => '50']) : '';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'content_id',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return Html::a(Content::findOne($model->content_id)->display_name, ['content/view', 'id' => $model->content_id], ['class' => 'label label-primary']);
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'price',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return Content::formatNumber($model->price).' Đ';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'sale',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return $model->sale?$model->sale.' %':' 0%';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'price_promotion',
            'format' => 'html',
            'value' => function ($model, $key, $index, $widget) {
                return Content::formatNumber($model->price_promotion).' Đ';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'number',
            'value' => function ($model, $key, $index, $widget) {
                return $model->number.' Sản phẩm';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'total',
            'value' => function ($model, $key, $index, $widget) {
                return Content::formatNumber($model->total).' Đ';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'created_at',
            'value' => function ($model, $key, $index, $widget) {
                return date('d/m/Y H:i:s', $model->created_at);
            },
        ],
    ],
]); ?>
