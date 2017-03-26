<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 3/26/2017
 * Time: 3:24 PM
 */
?>
<div id="cart-block" class="col-xs-5 col-sm-2 shopping-cart-box">
    <a class="cart-link" href="order.html">
        <span class="title">Giỏ hàng</span>
        <span class="total"><?= $totalAmount?$totalAmount:0 ?> SP - <?= $total_price?\common\models\Content::formatNumber($total_price):0 ?> VND</span>
        <span class="notify notify-left"><?= $totalAmount?$totalAmount:0 ?></span>
    </a>
    <div class="cart-block">
        <div class="cart-block-content">
            <h5 class="cart-title"><?= $totalAmount?$totalAmount:0 ?> Sản phẩm trong giỏ hàng</h5>
            <div class="cart-block-list">
                <ul>
                    <?php  if(isset($cartInfo) && !empty($cartInfo)){
                        foreach($cartInfo as $key =>$value){
                            ?>
                            <li class="product-info">
                                <div class="p-left">
                                    <a href="#" class="remove_link"></a>
                                    <a href="#">
                                        <img class="img-responsive" src="<?= \common\models\Content::getFirstImageLinkFeStatic($value['images'])?>" alt="p10">
                                    </a>
                                </div>
                                <div class="p-right">
                                    <p class="p-name"><?= $value['display_name'] ?></p>
                                    <p class="p-rice"><?= \common\models\Content::formatNumber($value['price_promotion'] != 0 ?$value['price_promotion']:$value['price']) ?> VND</p>
                                    <p>Số Lượng: <?= $value['amount'] ?></p>
                                </div>
                            </li>
                            <?php
                        }
                    }?>
                </ul>
            </div>
            <div class="toal-cart">
                <span>Tổng tiền</span>
                <span class="toal-price pull-right"><?= $total_price?\common\models\Content::formatNumber($total_price):0 ?> VND</span>
            </div>
            <div class="cart-buttons">
                <a href="<?= \yii\helpers\Url::to(['']) ?>" class="btn-check-out">Thanh toán</a>
            </div>
        </div>
    </div>
</div>
