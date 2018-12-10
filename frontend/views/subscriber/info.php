<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/2/2016
 * Time: 11:20 PM
 */
use common\models\Content;
use frontend\widgets\UserWidget;
use yii\helpers\Url;

/* @var $model common\models\Subscriber */
?>
<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="<?= Url::to(['site/index']) ?>" title="Return to Home"><?= Yii::t('app','Home') ?></a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page"><?= $model->full_name ? $model->full_name : $model->username ?></span>
        </div>
        <!-- ./breadcrumb -->
        <!-- page heading-->
        <h2 class="page-heading">
            <span class="page-heading-title2"><?= Yii::t('app','info') ?></span>
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
                                    <a href="#"><?= Yii::t('app','History') ?></a>
                                </li>
                                <li>
                                    <a href="#"><?= Yii::t('app','History of ') ?><?= $model->username ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="heading-counter warning"><?= Yii::t('app','Total manga') ?>:
                            <span><?= $histories ? count($histories): '0' ?></span>
                        </div>
                        <div class="order-detail-content">
                            <?php
                            if ($histories) {
                                ?>
                                <table class="table table-bordered table-responsive cart_summary">
                                    <thead>
                                    <tr>
                                        <th class="cart_product"><?= Yii::t('app','Code') ?></th>
                                        <th></th>
                                        <th><?= Yii::t('app','Name') ?></th>
                                        <th><?= Yii::t('app','In series') ?></th>
                                        <th><?= Yii::t('app','Date start read') ?></th>
                                        <th><?= Yii::t('app','Date read latest') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    /** @var \common\models\SubscriberHistory $history */
                                    foreach ($histories as $history) {
                                        ?>
                                        <tr>
                                            <td class="cart_product">
                                                <a href="<?= Url::to(['content/detail','id' => $history->content_id]) ?>">#<?= $history->code ?></a>
                                            </td>
                                            <td class="cart_avail">
                                                <a href="<?= Url::to(['content/detail', 'id' => $history->content_id]) ?>">
                                                    <img src="<?= \common\models\Content::getFirstImageLinkFeStatic($history->images) ?>"
                                                         alt="<?= $history->display_name ?>">
                                                </a>
                                            </td>
                                            <td class="qty">
                                                <?= $history->display_name ?>
                                            </td>
                                            <td class="price">
                                                <?= $history->parent_id?Content::findOne($history->parent_id)->display_name:'' ?>
                                            </td>
                                            <td class="text-center">
                                                <?= date('d/m/Y H:i:s', $history->time_read) ?>
                                            </td>
                                            <td class="text-center">
                                                <?= date('d/m/Y H:i:s', $history->time_again) ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                            } else {
                                ?>
                                <a href="<?= Url::home() ?>" type="button" class="button"> Tạo đơn hàng ngay</a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./page wapper-->
