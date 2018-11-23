<?php

use common\models\Category;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use common\models\Site;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
$images = !$model->isNewRecord && !empty($model->images);
$images_feature = !$model->isNewRecord && !empty($model->location_image);

$check = Html::getInputId($model, 'parent_id');
$js = <<<JS
    if($("#$check").val() != ''){
            $('#send_via_file').hide();
        }else {
            $('#send_via_file').show();
        }
        
    $("#$check").change(function() {
        if($('#$check').val() != ''){
            $('#send_via_file').hide('slow');
        }else {
            $('#send_via_file').show('slow');
        }
    });
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>

<?php $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fullSpan' => 8,
    'options' => ['enctype' => 'multipart/form-data'],
    'formConfig' => [
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'labelSpan' => 3,
        'deviceSize' => ActiveForm::SIZE_SMALL,
    ],
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
]); ?>
<div class="form-body">

    <?= $form->field($model, 'display_name')->textInput(['maxlength' => 200, 'class' => 'input-circle']) ?>

    <?= $form->field($model, 'images')->widget(\kartik\file\FileInput::classname(), [
        'pluginOptions' => [

            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' => 'Chọn hình ảnh',
            'initialPreview' => $images ? [
                Html::img(Yii::getAlias('@web') . '/' . Yii::getAlias('@category_image') . "/" . $model->images, ['class' => 'file-preview-image', 'style' => 'width: 100%;']),

            ] : [],
        ],
        'options' => [
            'accept' => 'image/*',
        ],
    ]);
    ?>

    <div id="send_via_file">
        <?= $form->field($model, 'location_image')->widget(\kartik\file\FileInput::classname(), [
            'pluginOptions' => [

                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' => 'Chọn hình ảnh',
                'initialPreview' => $images_feature ? [
                    Html::img(Yii::getAlias('@web') . '/' . Yii::getAlias('@category_image') . "/" . $model->location_image, ['class' => 'file-preview-image', 'style' => 'width: 100%;']),

                ] : [],
            ],
            'options' => [
                'accept' => 'image/*',
            ],
        ]);
        ?>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'status')->dropDownList(
        Category::getListStatus(), ['class' => 'input-circle']
    ) ?>

    <?php
    $dataList = \common\models\Category::getTreeCategories();
    $disableId = false;
    if (!$model->isNewRecord) {
        $disableId = $model->id;
    }
    echo $form->field($model, 'parent_id')->dropDownList($dataList,
        [
            'prompt' => Yii::t('app','-Chọn nhóm cha-'),
            'options' => \common\models\Category::getAllChildCats($model->id) + [$model->id => ['disabled' => true]]
        ]);
    ?>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Tạo danh mục') : Yii::t('app','Cập nhật'),
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app','Quay lại'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
