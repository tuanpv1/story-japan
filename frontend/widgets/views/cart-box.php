<?php
/**
 * Created by PhpStorm.
 * User: TuanPham
 * Date: 3/26/2017
 * Time: 3:24 PM
 */
use common\helpers\CUtils;

?>
<div class="col-xs-4 col-sm-1 group-button-header">
    <div class="btn-cart" id="cart-block">
        <a title="My cart" href="<?= \yii\helpers\Url::to(['shopping-cart/list-my-cart']) ?>">Giỏ hàng</a>
        <span class="notify notify-right"><?= $totalAmount ? $totalAmount : 0 ?></span>
        <div class="cart-block">
            <div class="cart-block-content">
                <h5 class="cart-title"><?= $totalAmount ? $totalAmount : 0 ?>
                    SP - <?= $total_price ? CUtils::formatNumber($total_price) : 0 ?> Đ</h5>
                <div class="cart-block-list">
                    <ul>
                        <?php if (isset($cartInfo) && !empty($cartInfo)) {
                            foreach ($cartInfo as $key => $value) {
                                ?>
                                <li class="product-info">
                                    <div class="p-left">
                                        <a onclick="delCart(<?= $key ?>)" href="javascript:void(0)"
                                           class="remove_link"></a>
                                        <a href="<?= \yii\helpers\Url::to(['content/detail', 'id' => $value['id']]) ?>">
                                            <img class="img-responsive"
                                                 src="<?= \common\models\Content::getFirstImageLinkFeStatic($value['images']) ?>"
                                                 alt="p10">
                                        </a>
                                    </div>
                                    <div class="p-right">
                                        <p class="p-name"><?= $value['display_name'] ?></p>
                                        <p class="p-rice"><?= CUtils::formatNumber($value['price_promotion'] != 0 ? $value['price_promotion'] : $value['price']) ?>
                                            Đ</p>
                                        <p>Số Lượng: <?= $value['amount'] ?></p>
                                    </div>
                                </li>
                                <?php
                            }
                        } ?>
                    </ul>
                </div>
                <div class="toal-cart">
                    <span>Tổng tiền</span>
                    <span class="toal-price pull-right"><?= $total_price ? CUtils::formatNumber($total_price) : 0 ?>
                        Đ</span>
                </div>
                <div class="cart-buttons">
                    <a href="<?= \yii\helpers\Url::to(['shopping-cart/list-my-cart']) ?>" class="btn-check-out">Thanh
                        toán</a>
                </div>
            </div>
        </div>
    </div>
</div>
