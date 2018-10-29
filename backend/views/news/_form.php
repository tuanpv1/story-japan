<?php

use common\models\News;
use dosamigos\ckeditor\CKEditor;
use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */

$images = !$model->isNewRecord && !empty($model->image_display);

$urlUploadImage = \yii\helpers\Url::to(['/app/upload']);
?>

<div class="form-body">

    <?php $form = ActiveForm::begin(
        [
            'options' => ['enctype' => 'multipart/form-data'],
            'method' => 'post',
        ]
    ); ?>
    <?php
    if ($type == News::TYPE_NEWS) {
        ?>
        <?= $form->field($model, 'type')->hiddenInput(['id' => 'type'])->label(false) ?>

        <?= $form->field($model, 'display_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList(\common\models\News::listStatus()) ?>

        <?= $form->field($model, 'image_display')->widget(\kartik\file\FileInput::classname(), [
            'pluginOptions' => [

                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' => 'Chọn hình ảnh',
                'initialPreview' => $images ? [
                    Html::img(Yii::getAlias('@web') . '/' . Yii::getAlias('@image_news') . "/" . $model->image_display, ['class' => 'file-preview-image', 'style' => 'width: 100%;']),

                ] : [],
            ],
            'options' => [
                'accept' => 'image/*',
            ],
        ]);
        ?>

        <?= $form->field($model, 'short_description')->textarea(['rows' => 4]) ?>

        <?php
    }
    ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
        'preset' => 'custom',
        'clientOptions' => [
            'filebrowserUploadUrl' => $urlUploadImage
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Tạo mới') : Yii::t('app', 'Cập nhật'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
