<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 12/2/2016
 * Time: 11:20 PM
 */
use frontend\widgets\UserWidget;
use yii\helpers\Url;

/* @var $model common\models\Subscriber */
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
                                    <a href="#">Đơn hàng</a>
                                </li>
                                <li>
                                    <a href="#">Danh sách đơn hàng của tài khoản <?= $model->username ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="heading-counter warning">Tổng số đơn hàng:
                            <span><?= $orders ? count($orders) . ' Đơn hàng' : 'Hiện bạn chưa có đơn hàng' ?></span>
                        </div>
                        <div class="order-detail-content">
                            <?php
                            if ($orders) {
                                ?>
                                <table class="table table-bordered table-responsive cart_summary">
                                    <thead>
                                    <tr>
                                        <th class="cart_product">Mã</th>
                                        <th>Trạng thái</th>
                                        <th>Số lượng SP</th>
                                        <th>Số tiền thanh toán</th>
                                        <th>Ngày tạo</th>
                                        <th>Xem</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    /** @var \common\models\Order $order */
                                    foreach ($orders as $order) {
                                        ?>
                                        <tr>
                                            <td class="cart_product">
                                                <a href="<?= Url::to(['subscriber/order-detail']) ?>">#<?= $order->id ?></a>
                                            </td>
                                            <td class="cart_avail">
                                                <span class="label label-success"><?= $order->getStatusName() ?></span>
                                            </td>
                                            <td class="qty">
                                                <span><?= $order->total_number ?></span>
                                            </td>
                                            <td class="price">
                                                <span><?= \common\helpers\CUtils::formatNumber($order->total) ?> Đ</span>
                                            </td>
                                            <td class="text-center">
                                                <?= date('d/m/Y H:i:s', $order->created_at) ?>
                                            </td>
                                            <td class="text-center">
                                                <a type="button"
                                                   href="<?= Url::to(['subscriber/order-detail', 'id' => $order->id]) ?>"><i
                                                            class="fa fa-eye"></i></a>
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
