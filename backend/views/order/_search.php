<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'name_buyer') ?>

    <?= $form->field($model, 'phone_buyer') ?>

    <?php // echo $form->field($model, 'address_buyer') ?>

    <?php // echo $form->field($model, 'email_buyer') ?>

    <?php // echo $form->field($model, 'email_receiver') ?>

    <?php // echo $form->field($model, 'name_receiver') ?>

    <?php // echo $form->field($model, 'phone_receiver') ?>

    <?php // echo $form->field($model, 'address_receiver') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'total_number') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
