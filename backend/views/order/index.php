<?php

use common\helpers\CUtils;
use common\models\Order;
use common\models\Product;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Đơn hàng');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span
                            class="caption-subject font-green-sharp bold uppercase"><?= $this->title ?> </span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'rowOptions' => function ($model) {
                        if ($model->status == Order::STATUS_SUCCESS) {
                            return ['class' => 'success'];
                        }
                        if ($model->status == Order::STATUS_ORDERED) {
                            return ['class' => 'warning'];
                        }
                        if ($model->status == Order::STATUS_ERROR) {
                            return ['class' => 'info'];
                        }
                        if ($model->status == Order::STATUS_TRANSPORT) {
                            return ['class' => 'danger'];
                        }
                    },
                    'columns' => [
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'id',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $widget) {
                                return Html::a($model->id, ['view', 'id' => $model->id], ['class' => 'label label-primary']);
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'name_buyer',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $widget) {
                                return $model->name_buyer;
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'created_at',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $widget) {
                                return date('d/m/Y H:i:s',$model->created_at);
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'phone_buyer',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $widget) {
                                return $model->phone_buyer;
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'total',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $widget) {
                                return CUtils::formatNumber($model->total) . ' VND';
                            },
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'total_number',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $widget) {
                                return $model->total_number . ' Sản phẩm';
                            },
                        ],
                        [
                            'class' => 'kartik\grid\EditableColumn',
                            'attribute' => 'status',
                            'width' => '200px',
                            'refreshGrid' => true,
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\Order */

                                return $model->getStatusName();
                            },
                            'editableOptions' => function ($model, $key, $index) {
                                return [
                                    'header' => 'Trạng thái',
                                    'size' => 'md',
                                    'displayValueConfig' => Order::getListStatus(),
                                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                                    'data' => Order::getListStatus(),
                                    'placement' => \kartik\popover\PopoverX::ALIGN_LEFT,
                                ];
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => Order::getListStatus(),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Tất cả'],
                        ],
                        [
                            'class' => 'kartik\grid\EditableColumn',
                            'attribute' => 'note',
                            'width' => '200px',
                            'refreshGrid' => true,
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\Order */

                                return $model->note;
                            },
                            'editableOptions' => function ($model, $key, $index) {
                                return [
                                    'header' => 'Ghi chú',
                                    'size' => 'md',
                                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                    'placement' => \kartik\popover\PopoverX::ALIGN_LEFT,
                                ];
                            },
                        ],
                        [
                            'class' => 'kartik\grid\EditableColumn',
                            'attribute' => 'book',
                            'width' => '200px',
                            'refreshGrid' => true,
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\Order */

                                return CUtils::formatNumber($model->book).' VND';
                            },
                            'editableOptions' => function ($model, $key, $index) {
                                return [
                                    'header' => 'Tiền đặt cọc',
                                    'size' => 'md',
                                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                    'placement' => \kartik\popover\PopoverX::ALIGN_LEFT,
                                ];
                            },
                        ],
                        [
                            'class' => 'kartik\grid\EditableColumn',
                            'attribute' => 'pay',
                            'width' => '200px',
                            'refreshGrid' => true,
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\Order */

                                return CUtils::formatNumber($model->pay).' VND';
                            },
                            'editableOptions' => function ($model, $key, $index) {
                                return [
                                    'header' => 'Tiền thu COD',
                                    'size' => 'md',
                                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                    'placement' => \kartik\popover\PopoverX::ALIGN_LEFT,
                                ];
                            },
                        ],
                        [
                            'class' => 'kartik\grid\EditableColumn',
                            'attribute' => 'date_pay',
                            'width' => '200px',
                            'refreshGrid' => true,
                            'value' => function ($model, $key, $index, $widget) {
                                /** @var $model \common\models\Order */

                                return $model->date_pay?date('d/m/Y H:i:s',$model->date_pay):'Chưa thiết lập';
                            },
                            'editableOptions' => function ($model, $key, $index) {
                                return [
                                    'header' => 'Ngày thu COD',
                                    'size' => 'md',
                                    'inputType' => \kartik\editable\Editable::INPUT_DATETIME,
                                    'placement' => \kartik\popover\PopoverX::ALIGN_LEFT,
                                ];
                            },
                        ],

                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

