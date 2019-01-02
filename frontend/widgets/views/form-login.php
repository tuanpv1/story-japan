<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/2/2016
 * Time: 9:10 AM
 */
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="row">
    <div class="col-sm-6">
        <div class="box-authentication">
            <div id="form_login">
                <h3 class="text-center"><?= Yii::t('app', 'Login') ?></h3>
                <?php
                $form = ActiveForm::begin([
                    'action' => \yii\helpers\Url::to(['site/login']),
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                ]);
                ?>

                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <button type="submit" name='login-button' class="button"><i
                            class="fa fa-lock"></i> <?= Yii::t('app', 'Login') ?></button>
                <?php ActiveForm::end(); ?>
            </div>
            <div id="tp_hidden_form_register">
                <h3 class="text-center"><?= Yii::t('app', 'Register') ?></h3>
                <?php $form = ActiveForm::begin([
                    'action' => \yii\helpers\Url::to(['site/signup']),
                    'id' => 'form-signup',
//                    'enableAjaxValidation' => true,
//                    'enableClientValidation' =>false,
                ]); ?>

                <?= $form->field($model_register, 'username')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'username')])->label(Yii::t('app', 'username') . ' (*)') ?>

                <?= $form->field($model_register, 'email')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'Email')])->label(Yii::t('app', 'Email') . ' (*)') ?>

                <?= $form->field($model_register, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Password')])->label(Yii::t('app', 'Password') . ' (*)') ?>

                <?= $form->field($model_register, 'confirm_password')->passwordInput(['placeholder' => Yii::t('app', 'Confirm Password')])->label(Yii::t('app', 'Confirm Password') . ' (*)') ?>

                <?= $form->field($model_register, 'phone_number')->textInput(['placeholder' => Yii::t('app','Phone number')]) ?>

                <?= $form->field($model_register, 'address')->textInput(['placeholder' => Yii::t('app','Address')]) ?>

                <button name="signup-button" class="button"><i class="fa fa-user"></i> <?= Yii::t('app', 'Register') ?>
                </button>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box-authentication">
            <div class="row">
                <div class="col-xs-12">
                    <?= Html::a(Yii::t('app', 'Forget password click here'), ['site/request-password-reset']) ?>.
                </div>
            </div>
            <button id="bt_tp_show" class="button"><i class="fa fa-user"></i> <?= Yii::t('app', 'Register') ?></button>
            <button id="bt_tp_hide" class="button"><i class="fa fa-lock"></i> <?= Yii::t('app', 'Login') ?></button>
        </div>
    </div>
</div>