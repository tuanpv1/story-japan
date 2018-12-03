<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InfoPublic */

$this->title = Yii::t('app', 'Xem thông tin cấu hình');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'QL Thông tin'), 'url' => ['index']];
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
                <div class="tabbable-custom ">

                    <p>
                        <?= Html::a(Yii::t('app', 'Cập nhật'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'image_header',
                                'format' => 'raw',
                                'value' => $model->image_header ? Html::img(Yii::getAlias('@web') . "/" . Yii::getAlias('@image_info') . "/" . $model->image_header, ['width' => '100px']) : '',
                            ],
                            'email:email',
                            'phone',
                            'link_face',
                            'google',
                            'youtube',
                            'twitter',
                            'address',
                            'convert_price_vnd',
                            [
                                'attribute' => 'payment_type',
                                'format' => 'html',
                                'value' => $model->payment_type
                            ],
                            'time_show_order',
                            [
                                'attribute' => 'created_at',
                                'value' => date('d/m/Y H:i:s', $model->created_at),
                            ],
                            [
                                'attribute' => 'updated_at',
                                'value' => date('d/m/Y H:i:s', $model->updated_at),
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
