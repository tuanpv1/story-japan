<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/2/2016
 * Time: 11:20 PM
 */
use common\models\Subscriber;
use common\models\User;
use frontend\widgets\UserWidget;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model common\models\Subscriber */
$avatarPreview = $model->isNewRecord;
?>
<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="<?= Url::to(['site/index']) ?>" title="Trang chủ">Home</a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page">
                <a class="home" href="<?= Url::to(['subscriber/info']) ?>" title="Trang cá nhân">
                    <?= $model->full_name ? $model->full_name : $model->username ?>
                </a>
            </span>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page">Cập nhật</span>
        </div>
        <!-- ./breadcrumb -->
        <!-- page heading-->
        <h2 class="page-heading">
            <span class="page-heading-title2">Cập nhật thông tin cá nhân</span>
        </h2>
        <!-- ../page heading-->
        <div class="page-content">
            <div class="row">
                <div class="col-sm-3">
                    <?= UserWidget::widget(['model' => $model]) ?>
                </div>
                <div class="col-sm-9">
                    <div class="page-content page-order">
                        <div class="subcategories">
                            <ul>
                                <li class="current-categorie">
                                    <a href="#">Cập nhật thông tin </a>
                                </li>
                                <li>
                                    <a href="#">Tài khoản <b><?= $model->username ?></b></a>
                                </li>
                            </ul>
                        </div>
                        <br>
                        <div class="col-md-6 col-md-offset-3 box-authentication tp_001">
                            <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => false,
                            ]); ?>
                            <div class="text-center">
                                <img style="width: 80px" src="<?= Subscriber::getImageLink() ?>"><br>
                            </div>

                            <?= $form->field($model, 'full_name')->textInput(['placeholder' => 'Họ và Tên', 'maxlength' => 100]) ?>

                            <?= $form->field($model, 'address')->textInput(['placeholder' => 'Địa chỉ', 'maxlength' => 100]) ?>

                            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email', 'maxlength' => 100]) ?>

                            <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Số điện thoại', 'maxlength' => 100]) ?>

                            <?=
                            $form->field($model, 'gender')->dropDownList([
                                'Chọn giới tính' => User::listGender(),
                            ])
                            ?>

                            <?=
                            $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Chọn ngày sinh'],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ])
                            ?>

                            <div class="text-center">
                                <?= Html::submitButton('Cập nhật', ['class' => 'button']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./page wapper-->
