<?php

use common\models\News;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model News */
/* @var $type */
$this->title = News::getTypeName($type);
$this->params['breadcrumbs'][] = $this->title;

$visible_campaign = false;
$visible_village = false;
?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase"><?= $this->title ?></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <p><?= Html::a('Thêm mới ' . $this->title, ['create', 'type' => $type], ['class' => 'btn btn-success']) ?> </p>
                <?php
                $columns = [
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'image_display',
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, $widget) {
                            /** @var $model \common\models\News */
                            $link = $model->getImageDisplayLink();
                            return $link ? Html::img($link, ['alt' => 'Thumbnail', 'width' => '200']) : '';
                        },
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'display_name',
                        'format' => 'html',
                        'value' => function ($model, $key, $index, $widget) {
                            /** @var $model \common\models\News */
                            return Html::a($model->display_name, ['view', 'id' => $model->id], ['class' => 'label label-primary']);
                        },
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'short_description',
                        'format' => 'html',
                        'value' => function ($model, $key, $index, $widget) {
                            /** @var $model \common\models\News */
                            return \common\helpers\CUtils::subString($model->short_description, 20);
                        },
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'status',
                        'format' => 'html',
                        'value' => function ($model, $key, $index, $widget) {
                            /** @var $model \common\models\News */
                            return $model->getStatusName();
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \common\models\News::listStatus(),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => "Tất cả"],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{update}{delete}',
                    ],
                ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $columns
                ]); ?>
            </div>
        </div>
    </div>
</div>
