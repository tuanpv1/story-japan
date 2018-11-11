<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\subscriber */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-body">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'fullSpan' => 12,
        'formConfig' => [
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'showLabels' => true,
            'labelSpan' => 2,
            'deviceSize' => ActiveForm::SIZE_SMALL,
        ],
//        'enableAjaxValidation' => true,
//        'enableClientValidation' => false,
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList(\common\models\Subscriber::listGender()) ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\Subscriber::listStatus()) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput() ?>

    <?= $form->field($model, 'about')->textInput(['maxlength' => true]) ?>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <!--            --><?php //Html::submitButton($model->isNewRecord ? 'Create and Close' : 'Update and Close',['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'onclick' => 'save_close()']) ?>
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Thêm mới') : Yii::t('app','Cập nhật'),['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app','Hủy thao tác'), ['index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
