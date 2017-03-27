<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 11/19/2016
 * Time: 9:42 PM
 */
use common\models\Product;
use yii\helpers\Url;

?>
<div id="tp_id_reload_lmc" class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="#" title="Return to Home"><?= Yii::t('app','Trang chủ') ?></a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page"><?= Yii::t('app','Giỏ hàng') ?></span>
        </div>
        <!-- ./breadcrumb -->
        <!-- page heading-->
        <h2 class="page-heading no-line">
            <span class="page-heading-title2"><?= Yii::t('app','Danh sách sản phẩm') ?></span>
        </h2>
        <!-- ../page heading-->
        <div class="page-content page-order">
            <ul class="step">
                <li class="current-step"><span>01. Sản phẩm đã chọn</span></li>
                <li><span>02. Sign in</span></li>
                <li><span>03. Address</span></li>
                <li><span>04. Shipping</span></li>
                <li><span>05. Payment</span></li>
            </ul>
            <div class="heading-counter warning"><?= Yii::t('app','Tổng số sản phẩm trong giỏ hàng của bạn ') ?>:
                <span><?= $totalAmount?$totalAmount:0 ?> Sản phẩm</span>
            </div>
            <?php if(isset($cart) && !empty($cart)){ ?>
            <div class="order-detail-content">
                <table class="table table-bordered table-responsive cart_summary">
                    <thead>
                    <tr>
                        <th class="cart_product"></th>
                        <th>Sản phẩm</th>
                        <th>Tình trạng.</th>
                        <th>Giá tiền</th>
                        <th>Số Lượng</th>
                        <th>Tổng tiền</th>
                        <th  class="action"><i class="fa fa-trash-o"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($cart as $key => $value){ ?>
                    <tr>
                        <td class="cart_product">
                            <a href="#"><img src="<?= \common\models\Content::getFirstImageLinkFeStatic($value['images']) ?>" alt="<?= $value['display_name'] ?>"></a>
                        </td>
                        <td class="cart_description">
                            <p class="product-name"><a href="#"><?= $value['display_name'] ?> </a></p>
                            <small class="cart_ref"><?= Yii::t('app','Mã sản phẩm: #').$value['code']  ?></small><br>
<!--                            <small><a href="#">Color : Beige</a></small><br>-->
                        </td>
                        <td class="cart_avail"><span class="label label-success"><?= \common\models\Content::$listAvailability[$value['availability']] ?></span></td>
                        <td class="price"><span><?= \common\models\Content::formatNumber($value['price_promotion']?$value['price_promotion']:$value['price']) ?> VND</span></td>
                        <td class="qty">
                            <input class="form-control input-sm" type="text" value="<?= $value['amount'] ?>">
                            <a href="#"><i class="fa fa-caret-up"></i></a>
                            <a href="#"><i class="fa fa-caret-down"></i></a>
                        </td>
                        <td class="price">
                            <span><?= \common\models\Content::formatNumber(($value['price_promotion']?$value['price_promotion']:$value['price'])*$value['amount']) ?> VND</span>
                        </td>
                        <td class="action">
                            <a onclick="delCart(<?= $key ?>)" href="javascript:void(0)"><?= Yii::t('app','Xóa') ?></a>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2" rowspan="2"></td>
                        <td colspan="3">Tổng tiền trước thuế</td>
                        <td colspan="2"><?= \common\models\Content::formatNumber($total_price?$total_price:0) ?> VND</td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong><?= Yii::t('app','Tổng tiền') ?></strong></td>
                        <td colspan="2"><strong><?= \common\models\Content::formatNumber($total_price?$total_price:0) ?> VND</strong></td>
                    </tr>
                    </tfoot>
                </table>
                <div class="cart_navigation">
                    <a class="prev-btn" href="<?= Url::to(['site/index']) ?>"><?= Yii::t('app','Tiếp tục mua hàng') ?></a>
                    <a class="next-btn" href="#"><?= Yii::t('app','Thanh toán') ?></a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>