<?php

use common\models\News;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = 'Cập nhật: ' . ' ' . $model->display_name;
$this->params['breadcrumbs'][] = ['label' => News::getTypeName($model->type), 'url' => ['index', 'type' => $model->type]];
$this->params['breadcrumbs'][] = ['label' => $model->display_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-gift"></i><?= $this->title ?></div>
            </div>
            <div class="portlet-body form">
                <?= $this->render('_form', [
                    'model' => $model,
                    'type'=>$model->type,
                ]) ?>
            </div>
        </div>
    </div>
</div>