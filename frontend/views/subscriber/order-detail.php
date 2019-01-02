<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/2/2016
 * Time: 11:20 PM
 */
use common\helpers\CUtils;
use frontend\widgets\UserWidget;
use yii\helpers\Url;

/* @var $model common\models\Subscriber */
/* @var $order common\models\Order */
?>
<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="<?= Url::to(['site/index']) ?>" title="Return to Home">Home</a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page"><?= $model->full_name ? $model->full_name : $model->username ?></span>
        </div>
        <!-- ./breadcrumb -->
        <!-- page heading-->
        <h2 class="page-heading">
            <span class="page-heading-title2">Thông tin cá nhân</span>
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
                                    <a href="<?= Url::to(['subscriber/info']) ?>">Đơn hàng</a>
                                </li>
                                <li>
                                    <a href="#">Chi tiết đơn hàng khách hàng <?= $model->username ?> mã đơn hàng #<?= $order->id ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="heading-counter warning">Đang xem chi tiết đơn hàng mã: #<?= $order->id ?>
                        </div>
                        <div class="order-detail-content">
                            <?php
                            if ($orderDetails) {
                                ?>
                                <table class="table table-bordered table-responsive cart_summary">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tên sản phẩm</th>
                                        <th>Trạng thái</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                        <th>Tổng tiền thanh toán</th>
                                        <th>Ngày tạo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    /** @var \common\models\OrderDetail $orderDetail */
                                    foreach ($orderDetails as $orderDetail) {
                                        ?>
                                        <tr>
                                            <td class="cart_product">
                                                <a href="<?= Url::to(['content/detail', 'id' => $orderDetail->content_id]) ?>">
                                                    <img src="<?= \common\models\Content::getFirstImageLinkFeStatic($orderDetail->image) ?>"
                                                         alt="<?= $orderDetail->display_name ?>">
                                                </a>
                                            </td>
                                            <td>
                                                <?= $orderDetail->display_name ?><br>
                                                Mã SP: #<?= $orderDetail->code ?>
                                            </td>
                                            <td class="cart_avail">
                                                <span class="label label-success"><?= $order->getStatusName() ?></span>
                                            </td>
                                            <td class="qty">
                                                <span><?= $orderDetail->number ?> SP</span>
                                            </td>
                                            <td class="price">
                                                <?php if ($orderDetail->price_promotion && $orderDetail->price_promotion != $orderDetail->price) {
                                                    ?>
                                                    Giá Khuyễn mãi: <?= CUtils::formatNumber($orderDetail->price_promotion) ?> Đ
                                                    <br>
                                                    Sale <?= $orderDetail->sale ?>%
                                                    <br> Giá gốc:
                                                    <?php
                                                } ?>
                                                <span><?= CUtils::formatNumber($orderDetail->price) ?> Đ</span>

                                            </td>
                                            <td class="price">
                                                <span><?= CUtils::formatNumber($order->total) ?> Đ</span>
                                            </td>
                                            <td class="text-center">
                                                <?= date('d/m/Y H:i:s', $order->created_at) ?>
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
