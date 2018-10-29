<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InfoPublic */

$this->title = Yii::t('app','Cập nhật cấu hình');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','QL Thông tin'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Xem thông tin cấu hình'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Cập nhật cấu hình');
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"> <i class="fa fa-gift"></i><?= $this->title ?></div>
            </div>
            <div class="portlet-body form">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
