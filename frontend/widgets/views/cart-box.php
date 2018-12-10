<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 3/26/2017
 * Time: 3:24 PM
 */
use yii\helpers\Url;

?>
<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 group-button-header">
    <a title="<?= Yii::t('app', 'Favourites') ?>" href="<?= Url::to(['subscriber/favourite']) ?>" class="btn-heart">
        <?= Yii::t('app', 'Favourites') ?>
    </a>
    <span class="notify notify-right"><?= $total_favourite ?></span>
</div>
