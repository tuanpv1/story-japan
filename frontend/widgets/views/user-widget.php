<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/3/2016
 * Time: 9:01 AM
 */
use common\models\Subscriber;
use yii\helpers\Url;

/* @var $model common\models\subscriber */
?>
<div class="box-authentication">
    <div class="text-center">
        <img style="width: 80px" src="<?= Subscriber::getImageLink() ?>"
             alt="<?= !empty($model->full_name) ? $model->full_name : $model->username ?>">
    </div>
    <br>
    <h3 class="text-center"><?= $model->full_name ? $model->full_name : $model->username ?></h3><br>
    <p><b>Giới tính:</b> <?= $model->getGenderName() ?></p><br>
    <p><b>Email:</b> <?= $model->email ? $model->email : 'Đang cập nhật' ?></p><br>
    <p><b>Địa chỉ:</b> <?= $model->address ? $model->address : 'Đang cập nhật' ?></p><br>
    <p><b>SDT:</b> <?= $model->phone ? $model->phone : 'Đang cập nhật' ?></p><br>
    <p><b>Giới thiêu:</b> <?= $model->about ? $model->about : 'Đang cập nhật' ?></p><br>
    <a type="button" href="<?= Url::to(['subscriber/update']) ?>" class="button"><i class="fa fa-user"></i> Cập nhật
        thông tin</a>
</div>
