<?php

use common\models\InfoPublic;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InfoPublicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','QL Thông tin');
$this->params['breadcrumbs'][] = $this->title;
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

                <p>
                    <?= Html::a(Yii::t('app','Thêm'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute'=>'image_header',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $widget) {
                                return $model->image_header ? Html::img(Yii::getAlias('@web') . "/" . Yii::getAlias('@image_banner') . "/" . $model->image_header, ['width' => '100px']) : '';
                            }
                        ],
                        [
                            'attribute'=>'image_footer',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $widget) {
                                return $model->image_footer ? Html::img(Yii::getAlias('@web') . "/" . Yii::getAlias('@image_banner') . "/" . $model->image_footer, ['width' => '100px']) : '';
                            }
                        ],
                        'email:email',
                        'phone',
                         'link_face',
                         'address',
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'status',
                            'label' => 'Trạng thái',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $widget) {
                                /**
                                 * @var $model InfoPublic
                                 */
                                if ($model->status == InfoPublic::STATUS_ACTIVE) {
                                    return '<span class="label label-success">' . $model->getStatusName() . '</span>';
                                } else {
                                    return '<span class="label label-danger">' . $model->getStatusName() . '</span>';
                                }

                            },
                            'filter' => InfoPublic::getListStatus(),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => "Tất cả"],
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

